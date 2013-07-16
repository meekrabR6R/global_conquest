<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Global Conquest</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- css -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <!---scripts-->
    <script type="text/javascript">
      var user_id = "{{ $_SESSION['user']['id'] }}";
      var user_fn = "{{ $_SESSION['user']['first_name'] }}";
      var user_ln = "{{ $_SESSION['user']['last_name'] }}";
      var BASE = "{{ URL::base(); ";
    </script>
  
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <!--<script src="js/map/make_game.js" type="text/javascript"></script>-->
    <script src="js/front_page/front_page_stuff.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    
  </head>
  <body onload="get_games();">
    <div id="fb-root"></div>
    <script src="js/front_page/facebook_client_stuff.js" type="text/javascript"></script>

    <div class="container">
      <h1>Global Conquest</h1>
      </br>
      </br>
      
      <h4>Create a New Game:</h4>
     
      <form id="new_game" action="{{ URL::base(); }}/new_game" method="post" onsubmit="return checkForm(this); ">      
        <div class="row">
          <div id="error" class="control-group span3">
            <label class="control-label" for="title">Game Title:</label> 
            <input name="title" type="text">
            <span id="error_text" class="help-inline"></span>
          </div>
          <div class="span3">
          Players: 
          
          <select name="num_plyrs">
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
          </select>
          </div>
          <div class="span3">
          Type: 
          <select name="type">
            <option>Public</option>
            <option>Private</option>
          </select>
          </div> 
          </div> 
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Make Game</button>
            <input name="maker_id" type="hidden" value="{{ $_SESSION['user']['id'] }}">
            <span id="game_made" class="help-inline"></span>
          </div>
      </form>
  
      <h4>Games in Progress:</h4>
       
      <table class="table table-bordered table-hover">
      @foreach($games as $game)
        <tr><td><a href="{{ URL::base(); }}/map?game_id={{ $game->game_id }}">{{ $game->title }}</a></td></tr>
      @endforeach
      </table>
    

      <div class="row">
        <div class="span12"><img class="img-rounded" src="{{ $img_loc; }}"><p>{{ $user['name']; }}</p></div>
      </div>
      <div class="buttons">
        <input class="btn" id="invite" type="button" value="invite friends" onclick="getFriends();">
      </div>
      <div id="setup"></div>
      <div id="curr_games"></div>
    </div>

    <div id="#test"></div>
  </body>
    
</html>