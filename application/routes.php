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

Route::get('map', array('uses' => 'map@map'));


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
			
			$plyr_name = array();
			$index = 0;
			for($i = 0; $i <= 41; $i++){
				array_push($plyr_name, $tot_players[$index++]->first_name);
				if($index == $plyr_count)
					$index = 0;
			}
			
			shuffle($plyr_name);
			foreach($plyr_name as $name)
				$insert = DB::query("insert into ".$game_table." (curr_owner) values('".$name."')");
				
		}
		
		
	}
        else if($_POST['funct'] == 'new_player'){
          //  $mysqli->query("insert into players (plyr_id, first_name, last_name, start_date) values('".$_POST['id']."','".$_POST['fn']."','".$_POST['ln']."','".$date."')");
        }
       
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