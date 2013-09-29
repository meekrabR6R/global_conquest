<?php

  class Leaderboard_Controller extends Base_Controller {
      
      public $restful = true;
      
      public function get_leaderboard() {

      	  $player_stats = Players::getLeaderboardStats();
         
          return View::make('leaderboard')
          				->with('player_stats', $player_stats);   
      }

      public function post_update_win() {
      	  $plyr_id = Input::get('plyr_id');
      	  Players::updateLeaderboardStats($plyr_id);
      }
  }