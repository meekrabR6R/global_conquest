<?php

class Facebook_Controller extends Base_Controller{
    
}

function fb(){
	
     $config = array();
     $config['appId'] = AppInfo::appID();
     $config['secret'] = AppInfo::appSecret();
     return $facebook = new Facebook($config);
}

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