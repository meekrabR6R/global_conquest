<?php

class Facebook_Controller extends Base_Controller{
    
	public $restful = true;
	
    public function get_login() {

    	$facebook = Facebook_Controller::getFB();
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
			     
			     Facebook_Controller::new_player($user['id'], $user['first_name'], $user['last_name']);

			     return View::make('home.index')
				   ->with('games', Games::all())
				   ->with('user', $user)
				   ->with('img_loc', $img_loc)
				   ->with('list', $friend_list);
			}
			catch(FacebookApiException $e){
				$user = null;
				phpinfo();
				$login = $facebook->getLoginUrl();
		    	echo '<a href="'.$login.'">LOGIN!</a>';
			}
		}
		else{
			phpinfo();
		    $login = $facebook->getLoginUrl();
		    echo '<a href="'.$login.'">LOGIN!</a>';
		    
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



