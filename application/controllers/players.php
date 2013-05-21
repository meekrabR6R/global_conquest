<?php

class Players_Controller extends Base_Controller{
    
    public function action_index(){
        return View::make('home.index')->with('players', Players::all());
    }
    
    public function postIndex(){
        
    }
}

?>