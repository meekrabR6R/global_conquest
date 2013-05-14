<?php
  require_once('sdk/src/facebook.php');
  require_once('utils.php');
  include 'AppInfo.php';
 
  $config = array();
  $config['appId'] = AppInfo::appID();
  $config['secret'] = AppInfo::appSecret();

  $facebook = new Facebook($config);
  $uid = $facebook->getUser();

  if($uid){
    try{
      $user = $facebook->api('/me');
      $img_loc = "http://graph.facebook.com/".$uid."/picture";
      
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
;  
?>