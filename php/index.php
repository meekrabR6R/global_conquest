<?php include 'facebook_server_stuff.php'; ?>

<?php if($uid){ ?>

<!DOCTYPE HTML> 
<html>
  <head>
    <title>Global Conquest</title>
    <!--css-->
    
    <!---scripts--->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="js/make_game.js" type="text/javascript"></script>
    <script src="js/front_page_stuff.js" type="text/javascript"></script>
    
  </head>
  <body>
    <div id="fb-root"></div>
    <script src="js/facebook_client_stuff.js" type="text/javascript"></script>
    
        <h3>Global Conquest</h3>
        <table>
            <tr><td><img src="<?php echo $img_loc;?>"><p><?php echo $user['name'];?></p></td></tr>
            <tr><th>Games</th></tr>
            <tr><td>------------------------------------------</td></tr>
            <tr>
              <td><input id="invite" type="button" value="invite friends" onclick="getFriends();"></td>
              <td><input id="create" type="button" value="new game"></td>
              <tr><td><div id="setup"></div></td></tr>
            </tr>
            <tr><td>------------------------------------------</td></tr>
            <tr><td>Games in Progress:</td></tr>
            <tr><td>------------------------------------------</td></tr>
        </table>
       
  </body>
    
</html>
<?php }?>