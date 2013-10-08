<?php

  class Goblin_Controller extends Base_Controller {
      
      public $restful = true;
      
      public function get_goblin_snatcher() {
          Asset::add('risk_style', 'css/risk_style.css');
          $game_id = $_GET['game_id'];
          return View::make('goblin_snatch')->with('game_id', $game_id);   
      }
  }