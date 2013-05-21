<?php

class Games_Controller extends Base_Controller{
    
    public $restful = true;
    
    public function action_index(){
        return View::make('home.index')->with('games', Games::all());
    }
    
    public function post_index(){
       
        $raw_date = getdate();
        $date = $raw_date['year']."-".$raw_date['mon']."-".$raw_date['mday'];
       
        $new_game = Input::get('data'); 
        $add_game = array();
                                                                   
        foreach($new_game as $x)
            $add_game[] = $x['value'];
                
        $new_game = array(
            'title' => $add_game[0],
            'plyrs' => $add_game[1],
            'type' => $add_game[2],
            'maker_id' => $add_game[3],
            'start_date' =>$date
        );
        
        Games::create($new_game);
        
        return Redirect::to('/');
    }
}

?>