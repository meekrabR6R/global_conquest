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


<!DOCTYPE HTML> 
<html>
  <head>
    <title>Global Conquest</title>
         <!---scripts--->
         <script src="js/make_game.js" type="text/javascript"></script>
      
  </head>
  <body>
    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        // init the FB JS SDK
        FB.init({
          appId      : '<?php echo $config['appId'];?>',                        // App ID from the app dashboard
          channelUrl : 'localhost/globa/php/channel.html', // Channel file for x-domain comms
          status     : true,                                 // Check Facebook Login status
          cookie     : true,
          xfbml      : true                                  // Look for social plugins on the page
        });
    
        // Additional initialization code such as adding Event Listeners goes here
        FB.getLoginStatus(function(response){
       
          if (response.status === 'connected') {
            gPlayerFBID = response.authResponse.userID ? response.authResponse.userID : null;
            
          }
        });
        
        
              
      };
    
      // Load the SDK asynchronously
      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/all.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
      
      function getFriends() {
                
            FB.ui({
              method: 'apprequests',
              title: 'Global Conquest',
              message: 'Come get pwned!',
              }, fbCallback);
        }
        
      function fbCallback(response) {
        if(response && response.request_ids) {
              // Here, requests have been sent, facebook gives you the ids of all requests
              console.log(response);
              top.location.href='invite.php?req='+response.request_ids;;
              
         }
         else {
              alert(response)
         }
        
          console.log(response);
      } 
    </script>
    
        <h3>Global Conquest</h3>
        <table>
            <tr><td><img src="<?php echo $img_loc;?>"><p><?php echo $user['name'];?></p></td></tr>
            <tr><th>Games</th></tr>
            <tr><td>------------------------------------------</td></tr>
            <tr><td><input id="create" type="button" value="new game" onclick="getFriends();"></td></tr>
            <tr><td>------------------------------------------</td></tr>
            <tr><td>Games in Progress:</td></tr>
            <tr><td>------------------------------------------</td></tr>
        </table>
       
  </body>
    
</html>
