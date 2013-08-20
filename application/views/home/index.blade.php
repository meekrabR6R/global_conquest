<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Global Conquest</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- css -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">

    <!---scripts-->
    <script type="text/javascript">
      var user_id = "{{ $_SESSION['user']['id'] }}";
      var user_fn = "{{ $_SESSION['user']['first_name'] }}";
      var user_ln = "{{ $_SESSION['user']['last_name'] }}";
      var BASE = "{{ URL::base(); }}";
    </script>
  
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <!--<script src="js/map/make_game.js" type="text/javascript"></script>-->
    <script src="js/front_page/front_page_stuff.js" type="text/javascript"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    
  </head>
  <body>
    <header class="navbar navbar-inverse">
      <h3>Global Conquest</h3>
    </header>
    <div id="fb-root"></div>
    <script src="js/front_page/facebook_client_stuff.js" type="text/javascript"></script>

    <div class="container">
        <div class="alert alert-info">
          <h3>Recent Changes</h3>
          <ul>
            <li>Added basic player info to 'players' section on game map (player color/name/pic)</li>
            <li>Added turn-in count to 'cards' section of game map</li>
            <li>Adjusted presentation logic to preven 1st player from being able to place first turn armies before everyone else has placed initial armies.</li>
            <li>Autodisabled 'roll' and 'place armies' buttons while resulting javascript executes (generally lasts less than 15 ms). I think the weird 2-army
                attack bug was being caused by the button being clicked too many times before previous rolls were finished executing. The new slowdown is barely
                noticable.</li>
          </ul>
          <br>
          <h3>Known Issues</h3>
          <ul>
            <li>No territory bonus for card turn-ins (yet)</li>
            <li>When a player loses, the turn rotation still lands on them.</li>
            <li>Notification does not appear for winner/loser</li>
          </ul>
          <h3>Let me know if you find any bugs.</h3>
        </div>
        <h2>Create a New Game</h2>
       
       <form class="form-horizontal" id="new_game" action="{{ URL::base(); }}/new_game" method="post" onsubmit="return checkForm(this); ">
        <div class="form-group">
          <label class="col-lg-2 control-label" for="title">Game Title</label> 
          <div id="error" class="col-lg-10">
            <input class="form-control" name="title" placeholder="Game Title" type="text">
            <span id="error_text" class="help-inline"></span>
          </div>
        </div>
        <div class="form-group">
          <label for="players" class="col-lg-2 control-label">Players</label>
          <div class="col-lg-10">
            <select class="form-control" name="num_plyrs">
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
              <option>6</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-2 control-label" for="title">Type</label> 
          <div class="col-lg-offset-2 col-lg-10">
             <select class="form-control" name="type">
              <option>Public</option>
              <option>Private</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10">
            <button type="submit" class="btn btn-default">Make Game</button>
            <input name="maker_id" type="hidden" value="{{ $_SESSION['user']['id'] }}">
            <span id="game_made" class="help-inline"></span>
          </div>
        </div>
      </form>

      
        <h2>Games</h2>
        
        <table class="table table-bordered table-hover">
          <tr>
            <th>Game</th>
            <th>Player Count</th>
            <th>Active</th>
            <th>Player Up</th>
          </tr>
        @foreach($games as $game)
          <tr>
            <td><a href="{{ URL::base(); }}/map?game_id={{ $game['game_id'] }}">{{ $game['game_title'] }}</a></td>
            <td><p>{{ $game['player_count'] }}/{{ $game['player_max'] }}</p></td>
            <td>
              <p>
              @if($game['active']) 
                Yes
              @else
                No
              @endif
              </p>
            </td>
            
            <td>
              <p>
              @foreach($players as $player)
                @if($player->game_id == $game['game_id'] && $player->trn_active)
                  
                  @foreach($player_profiles as $profile)
                    @if($profile->plyr_id == $player->plyr_id && $profile->plyr_id != $user['id'])
                      {{ $profile->first_name.' '. $profile->last_name }}
                    @endif
                  @endforeach
                  
                  @if($user['id'] == $player->plyr_id)
                    You
                  @endif
                
                @endif
              @endforeach
              </p>
            </td>
          </tr>
        @endforeach
        </table>
      </div>
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