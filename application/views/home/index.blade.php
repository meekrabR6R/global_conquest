<html>
  <head>
    <title>Global Conquest</title>
    <!--css-->
    
    <!---scripts--->
    <script type="text/javascript">
    var user_id = "{{ $_SESSION['user']['id'] }}";
    var user_fn = "{{ $_SESSION['user']['first_name'] }}";
    var user_ln = "{{ $_SESSION['user']['last_name'] }}";
    var BASE = "{{ URL::base(); }}";
    </script>
  
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="js/make_game.js" type="text/javascript"></script>
    <script src="js/front_page_stuff.js" type="text/javascript"></script>
    
  </head>
  <body onload="add_player(); get_games();">
   
    <div id="fb-root"></div>
    <script src="js/facebook_client_stuff.js" type="text/javascript"></script>
       
        <h3>Global Conquest</h3>
       
        <table>
            <tr><td><img src="{{ $img_loc; }}"><p>{{ $user['name']; }}</p></td></tr>
            <tr><th>Games</th></tr>
            <tr><td>------------------------------------------</td></tr>
            <tr>
              <td><input id="invite" type="button" value="invite friends" onclick="getFriends();"></td>
              <td><input id="create" type="button" value="new game"></td>
            </tr>
            <tr><td><div id="setup"></div></td></tr>
            <tr><td>------------------------------------------</td></tr>
            <tr><td>Games in Progress:</td></tr>
            <tr><td>------------------------------------------</td></tr>
              @foreach($games as $game)
                <tr><td><a href="{{ URL::base(); }}/map?game_id={{ $game->game_id }}">{{ $game->title }}</a></td></tr>
              @endforeach
            <div id="curr_games"></div>
        </table>
       <div id="#test"></div>
  </body>
    
</html>