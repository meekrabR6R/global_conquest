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
	    <table class="table table-bordered table-hover">
	      <tr>
              <th>Player</th>
              <th>2-Player</th>
              <th>3-Player</th>
              <th>4-Player</th>
              <th>5-Player</th>
              <th>6-Player</th>
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
                <td>{{ $stat['total'] }}</td>
              </tr>
          @endforeach
	    </table>
	  </div>
  </body>
</html>