
     window.fbAsyncInit = function() {
          // init the FB JS SDK
          FB.init({
            appId      : '535852776460879',    // App ID from the app dashboard
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
      
     function getPlayers() {
        var player_friends = [];
        
        FB.api({
           method: 'fql.query',
           query: 'SELECT uid, name, is_app_user, pic_square FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me()) AND is_app_user = 1',
           },function(response_app_usr){
              
               if(response_app_usr.length > 0) {
                 
                   response_app_usr.forEach(function(index1){
                         
                         FB.api('/me/friends', function(response_friends) {
                             if(response_friends.data) {
                                  
                                  $.each(response_friends.data,function(index,friend) {
                                     
                                     if (friend.id == index1.uid){
                                         player_friends.push(friend.id);
                                         
                                     }
                                 });
                                 player_friends.join;
                                 alert(player_friends);
                             } else 
                                 console.log("Error!");
                             
                         });
                   });
               }
           });
        
       
     }
      
        
     function fbCallback(response) {
       if(response && response.request_ids) {
             // Here, requests have been sent, facebook gives you the ids of all requests
             console.log(response);
             top.location.href='invite.php?req='+response.request_ids;;
             
        }
        else {
             console.log("fuck");
        }
       
     
     }
