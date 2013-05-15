<?php
require_once('C:/wamp/www/global_conquest/application/models/sdk/src/facebook.php');
require_once('C:/wamp/www/global_conquest/application/models/utils.php');
include 'C:/wamp/www/global_conquest/application/models/AppInfo.php';
  
class Home_Controller extends Base_Controller {

	/*
	|--------------------------------------------------------------------------
	| The Default Controller
	|--------------------------------------------------------------------------
	|
	| Instead of using RESTful routes and anonymous functions, you might wish
	| to use controllers to organize your application API. You'll love them.
	|
	| This controller responds to URIs beginning with "home", and it also
	| serves as the default controller for the application, meaning it
	| handles requests to the root of the application.
	|
	| You can respond to GET requests to "/home/profile" like so:
	|
	|		public function action_profile()
	|		{
	|			return "This is your profile!";
	|		}
	|
	| Any extra segments are passed to the method as parameters:
	|
	|		public function action_profile($id)
	|		{
	|			return "This is the profile for user {$id}.";
	|		}
	|
	*/
	
	
	public function action_index(){
		return View::make('home.index');
	}
	
	public function action_welcome(){
		
		$config = array();
		$config['appId'] = AppInfo::appID();
		$config['secret'] = AppInfo::appSecret();
	  
		$facebook = new Facebook($config);
		$uid = $facebook->getUser();
	
		if($uid){
		     try{
		          $user = $facebook->api('/me');
		          $img_loc = "http://graph.facebook.com/".$uid."/picture";
		          return View::make('home.index')
				->with('user', $user)
				->with('img_loc', $img_loc);
		     }
		     catch(FacebookApiException $e){
		        if(!$uid)
		           exit();
		     }
	        }
		else{
		    $login = $facebook->getLoginUrl();
		    echo '<a href="'.$login.'">LOGIN!</a>';
		    
		 }
	}

}