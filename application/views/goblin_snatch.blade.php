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
    <!--Scripts-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/goblin_snatcher.js" type="text/javascript"></script>
  </head>
  <body>
    <header class="navbar  navbar-inverse">
        <div class="navbar-inner">
            <div class="head container">
                <h3 class="app_title">Goblin Snatcher</h3>
            </div>
            <nav>
              <ul class="nav pull-right"> 
                  <li><a class="navbar-link app_home" href="map?game_id={{ $game_id }}">Go Back to Game</a></li>
              </ul>
          </nav>
        </div>
    </header>
    <div class="container">
      <h5>I don't know why...</h5>
      <div id="image" class="img-responsive" style="height:487px;">
        <canvas id="game_map" class="img-responsive" width="512" height="480"></canvas>
      </div>
      <p> 'W' = Up, 'A' = Right, 'S' = Down, 'D' = Left
    </div>
  </body>
</html>