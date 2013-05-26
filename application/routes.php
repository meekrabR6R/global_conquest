<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

function fb(){
	
     $config = array();
     $config['appId'] = AppInfo::appID();
     $config['secret'] = AppInfo::appSecret();
     return $facebook = new Facebook($config);
}

Route::get('/', function(){
	
	$facebook = fb();
	$uid = $facebook->getUser();
	
	if($uid){
		try{
			
		     $user = $facebook->api('/me');
		     $friend_list = $facebook->api(array('method' => 'fql.query',
					'query' => "SELECT uid FROM user WHERE is_app_user = '1'
					AND uid IN (SELECT uid2 FROM friend
					WHERE uid1 = '" . $uid . "');"));
		     
		     $img_loc = "http://graph.facebook.com/".$uid."/picture";
		     $_SESSION['user'] = $user;
		     
		     return View::make('home.index')
			   ->with('games', Games::all())
			   ->with('user', $user)
			   ->with('img_loc', $img_loc)
			   ->with('list', $friend_list);
		}
		catch(FacebookApiException $e){
		   if(!$uid){
		      $login = $facebook->getLoginUrl();
		      echo '<a href="'.$login.'">LOGIN!</a>';
		   }
		}
	}
	else{
	    $login = $facebook->getLoginUrl();
	    echo '<a href="'.$login.'">LOGIN!</a>';
	    
	}
});

Route::get('map', function(){
	
	$facebook = fb();
	$user = $facebook->api('/me');
	
	
	Asset::add('risk_style', 'css/risk_style.css');
        Asset::add('jquery', 'js/jquery20.js');
        Asset::add('chat', 'js/chat.js', 'jquery');
        Asset::add('new_chat', 'js/new_chat.js', 'jquery');
        Asset::add('graph', 'js/graph.js', 'jquery');
        Asset::add('territory_setter', 'js/territory_setter.js', 'jquery');
        Asset::add('attack', 'js/attack.js', 'jquery');
        Asset::add('move_armies', 'js/move_armies.js', 'jquery');
	Asset::add('make_game', 'js/make_game.js', 'jquery');
        
	$game_id = $_GET['game_id'];
	$game = Games::where('game_id', '=', $game_id)->first();
	
	$plyr_id = Plyrgames::where('game_id','=', $game_id)->get();
	$plyr_count = Plyrgames::where('game_id','=', $game_id)->count();
	$plyr_fn_qry = DB::query('select first_name from players, plyr_games where plyr_games.plyr_id = players.plyr_id');
	
	$game_table = $game->title.''.$game_id;
	$plyr_fn = array();
	
	$join_flag = 0;
	$fn_addflag = 0;
	
	foreach($plyr_fn_qry as $player)
		array_push($plyr_fn, $player->first_name);
	
	foreach($plyr_id as $player){
		if($user['id'] == $player->plyr_id)
			$join_flag = 1;
	}
	
	$check = DB::only('SELECT COUNT(*) as `exists`
			   FROM information_schema.tables
			   WHERE table_name IN (?)
			   AND table_schema = database()',$game_table);

	if(!$check){
		Schema::create($game_table, function($table){
			$table->increments('id');
			$table->string('curr_owner');
			$table->integer('army_cnt')->default(1);
			//$table->timestamps();
		});
		
		
	
	}
	else if($plyr_count == $game->plyrs){
		$game_state = DB::query('select * from '. $game_table);
		$plyr_nm_color = array();
		
		foreach($plyr_id as $player){
			
			$plyr_index = DB::query('select first_name, plyr_color from plyr_games, players
				  where plyr_games.plyr_id = players.plyr_id
                                  and plyr_games.plyr_id ='.$player->plyr_id);
			
			array_push($plyr_nm_color, $plyr_index);
		}
		
		
		return View::make('game_map')
			->with('game', $game)
			->with('plyr_id', $plyr_id)
			->with('plyr_fn', $plyr_fn)
			->with('join_flag', $join_flag)
			->with('plyr_count', $plyr_count)
			->with('uid', $user['id'])
			->with('user_fn', $user['first_name'])
			->with('game_state', $game_state)
			->with('plyr_nm_color', $plyr_nm_color);
		
	}
	
	return View::make('game_map')
		->with('game', $game)
		->with('plyr_id', $plyr_id)
		->with('plyr_fn', $plyr_fn)
		->with('join_flag', $join_flag)
		->with('plyr_count', $plyr_count)
		->with('uid', $user['id'])
		->with('user_fn', $user['first_name']);
		
});


Route::post('db', function(){
	       
        if(Input::get('funct') == 'new_game'){
            $new_game = Input::get('data'); 
            $add_game = array();
                                                                   
            foreach($new_game as $x)
                $add_game[] = $x['value'];
             
                
	     $new_game = array(
		'title' => $add_game[0],
		'plyrs' => $add_game[1],
		'type' => $add_game[2],
		'maker_id' => $add_game[3],
 	     );
	     
	     
             Games::create($new_game);
	     
	     $game = Games::where('title', '=', $add_game[0])->first();
	     
	     $plyr_game_record = array(
		'plyr_id' => $add_game[3],
		'game_id' => $game->game_id,
	     );
	     
	     Plyrgames::create($plyr_game_record);
	     
	  
        }
        
	else if(Input::get('funct') == 'join'){
		
		$game_id = Input::get('game_id');
		$game = Games::where('game_id', '=', $game_id)->first();
		
		$game_table = $game->title.''.$game_id;
		
		$plyr_count = Plyrgames::where('game_id','=', $game_id)->count();
		
		$plyr_join = array(
			'plyr_id' => Input::get('uid'),
			'game_id' => Input::get('game_id'),
			'plyr_color' => Input::get('plyr_color')
		);
		
		if($plyr_count < $game->plyrs){
			Plyrgames::create($plyr_join);
			$plyr_count++;
		}
		
		if($plyr_count == $game->plyrs){
			$tot_players = DB::query('select first_name from players, plyr_games 
						  where  players.plyr_id = plyr_games.plyr_id
						  and plyr_games.game_id = ?', $game_id);
			
			$index = 0;
			for($i = 0; $i <= 41; $i++){
				$insert = DB::query("insert into ".$game_table." (curr_owner) values('".$tot_players[$index++]->first_name."')");
				if($index == $plyr_count)
					$index = 0;
			}
		}
		
		echo "SUCCESS!";
	}
        else if($_POST['funct'] == 'new_player'){
          //  $mysqli->query("insert into players (plyr_id, first_name, last_name, start_date) values('".$_POST['id']."','".$_POST['fn']."','".$_POST['ln']."','".$date."')");
        }
       
       // $mysqli->close();
});

Route::get('db', function(){
     
     $raw_date = getdate();
     $date = $raw_date['year']."-".$raw_date['mon']."-".$raw_date['mday'];
        
     $mysqli = new mysqli('localhost', 'root', null, 'global_conq');
    
     if($_GET['funct'] == 'get'){
          $result = $mysqli->query("select * from games");//finetune this
          var_dump($result->fetch_all());
     }
     $mysqli->close();
});
/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application. The exception object
| that is captured during execution is then passed to the 500 listener.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function($exception)
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});




//Controllers
Route::controller('games');
Route::controller('players');