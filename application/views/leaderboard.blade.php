<!DOCTYPE HTML> 
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>Global Conquest</title>
    <!--CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    {{ Asset::styles(); }}
     <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  </head>
  <body>
    <header class="navbar  navbar-inverse">
        <div class="navbar-inner">
            <div class="head container">
                <h3 class="app_title">Global Conquest</h3>
                <nav>
                    <ul class="nav pull-right"> 
                        <li><a class="navbar-link app_home" href="{{ URL::base() }}/">Home</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <div class="container">
      <h3 class="app_title text-center">Leader Board</h3>
	    <table class="table table-bordered table-hover">
	      <tr>
              <th>Player</th>
              <th>2-Player</th>
              <th>3-Player</th>
              <th>4-Player</th>
              <th>5-Player</th>
              <th>6-Player</th>
              <th>Kill Count</th>
              <th>Points</th>
          </tr>
	      @foreach($player_stats as $stat)
              <tr>
                <td>
                  <img src="http://graph.facebook.com/{{ $stat['player']->plyr_id }}/picture"><br>
                  {{ $stat['player']->first_name}} {{ $stat['player']->last_name }}
                </td>
                <td>{{ $stat['player']->two_win }}</td>
                <td>{{ $stat['player']->three_win }}</td>
                <td>{{ $stat['player']->four_win }}</td>
                <td>{{ $stat['player']->five_win }}</td>
                <td>{{ $stat['player']->six_win }}</td>
                <td>{{ $stat['player']->kill_count }}</td>
                <td>{{ $stat['total'] }}</td>
              </tr>
          @endforeach
	    </table>
      <h4>Point System</h4>
      <p>The point system works as follows:</p>
      <p>A win in a</p>
      <ul>
        <li>2-player game is worth 2 points</li>
        <li>3-player game is worth 3 points</li>
        <li>4-player game is worth 4 points</li>
        <li>5-player game is worth 5 points</li>
        <li>6-player game is worth 6 points</li>
      </ul>
      <p>A kill is worth 1 point.</p>
      <p>The points are summed, and the total is displayed in the column furthest to the right.<br>
         The table is sorted from greatest to least. The player with the highest point count is
         the top-ranked player.
      </p>
	  </div>
  </body>
</html>