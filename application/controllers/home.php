<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/global/application/models/sdk/src/facebook.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/global/application/models/utils.php');
include $_SERVER['DOCUMENT_ROOT'].'/global/application/models/AppInfo.php';
  
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
	
	
	//public function action_index(){
//		return View::make('home.index');
//	}
	
	public function action_index(){
		
		$config = array();
		$config['appId'] = AppInfo::appID();
		$config['secret'] = AppInfo::appSecret();
	  
		$facebook = new Facebook($config);
		$uid = $facebook->getUser();
	
		if($uid){
		     try{
		          $user = $facebook->api('/me');
			  $list = $facebook->api(array('method' => 'fql.query',
						       'query' => "SELECT uid FROM user WHERE is_app_user = '1' AND uid IN (SELECT uid2 FROM friend
						       WHERE uid1 = '" . $uid . "');"));
			  
		          $img_loc = "http://graph.facebook.com/".$uid."/picture";
			  
		          return View::make('home.index')
				->with('user', $user)
				->with('img_loc', $img_loc)
				->with('list', $list);
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
	}

}