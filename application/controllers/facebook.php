<?php

class Facebook_Controller extends Base_Controller{
    
    public $restful = true;
	
    public function get_login() {
    	Facebook_Controller::facebook_login();
    }

    public function post_login(){
    	Facebook_Controller::facebook_login();
    }

    private static function facebook_login(){
    	
    	$facebook = Facebook_Controller::getFB();
		$uid = $facebook->getUser();
		
		if($uid){
			
			try{
			     $user = $facebook->api('/me');
			     $friend_list = $facebook->api(array('method' => 'fql.query',
						'query' => "SELECT uid,name FROM user WHERE is_app_user = '1'
						AND uid IN (SELECT uid2 FROM friend
						WHERE uid1 = '" . $uid . "');"));
			     
			     $img_loc = "http://graph.facebook.com/".$uid."/picture";
			     $_SESSION['user'] = $user;
			     
			     Facebook_Controller::new_player($user['id'], $user['first_name'], $user['last_name']);

			     //move to model
			     $games = array();
			     foreach(Games::all() as $game){
			     	$player_count = Plyrgames::where('game_id', '=', $game->game_id)->count();
			     	array_push($games, array('game_id' => $game->game_id, 'game_title' => $game->title, 'player_count' => $player_count, 'player_max' => $game->plyrs, 'active' => $game->active));
			     }

			     return View::make('home.index')
				   ->with('games', $games)
				   ->with('players', Plyrgames::all())
				   ->with('player_profiles', Players::all())
				   ->with('user', $user)
				   ->with('img_loc', $img_loc)
				   ->with('list', $friend_list);
			}
			catch(FacebookApiException $e){
				$user = null;
			
				$login = $facebook->getLoginUrl();
		    
		    	return View::make('home.login')
		    		->with('login', $login);
			}
		}
		else{
	
		    $login = $facebook->getLoginUrl();
		    //echo '<a href="'.$login.'">LOGIN!</a>';
		    return View::make('home.login')
		    		->with('login', $login);
		    
		}
    }
    
    private static function new_player($id, $fn, $ln){
        
        $player_check = Players::find($id);

        if(!$player_check){ 
	        $new_player = array(
	                'plyr_id' => $id,
	                'first_name' => $fn,
	                'last_name' => $ln
	        );
	        
	        Players::create($new_player);
	    }
    }
}



