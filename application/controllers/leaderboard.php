<?php

  class Leaderboard_Controller extends Base_Controller{
      
      public $restful = true;
      
      public function get_leaderboard() {
          return View::make('leaderboard');   
      }
  }