<?php

class Games_Controller extends Base_Controller{
    
    public $restful = true;

    public function get_games(){
     
        $result = Games::all();
         
        foreach($result as $game){
            echo  '<tr><td><a href="'. URL::base() .'/map?game_id='. $game->game_id .'>'. $game->title .'</a></td></tr>';
        }
    }

    public function post_new_game(){
        
        $new_game = Input::get('data'); 
        $add_game = array();
                                                               
        foreach($new_game as $x)
            $add_game[] = $x['value'];
         
        
        $new_game = array(
            'title' => $add_game[0],
            'plyrs' => $add_game[1],
            'type' => $add_game[2],
            'maker_id' => $add_game[3],
        );
     
     
         Games::create($new_game);
     
         $game = Games::where('title', '=', $add_game[0])->first();
        
        $plyr_game_record = array(
            'plyr_id' => $add_game[3],
            'game_id' => $game->game_id,
            'init_armies' => Games_Controller::setInitArmies($game->plyrs)
         );
     
        Plyrgames::create($plyr_game_record);
         
      
        
    }

    public function post_join(){

        $game_id = Input::get('game_id');
        $game = Games::where('game_id', '=', $game_id)->first();
        
        $game_table = $game->title.''.$game_id;
        
        $plyr_count = Plyrgames::where('game_id','=', $game_id)->count();

        $plyr_join = array(
            'plyr_id' => Input::get('uid'),
            'game_id' => Input::get('game_id'),
            'plyr_color' => Input::get('plyr_color'),
            'init_armies' =>  Games_Controller::setInitArmies($game->plyrs)
        );
        
        if($plyr_count < $game->plyrs){
            Plyrgames::create($plyr_join);
            $plyr_count++;
        }
        
        if($plyr_count == $game->plyrs){
            $tot_players = DB::query('select players.plyr_id from players, plyr_games 
                          where  players.plyr_id = plyr_games.plyr_id
                          and plyr_games.game_id = ?', $game_id);
            
            $plyr_id = array();
            $index = 0;
            for($i = 0; $i <= 41; $i++){
                array_push($plyr_id, $tot_players[$index++]->plyr_id);
                if($index == $plyr_count)
                    $index = 0;
            }
            
            shuffle($plyr_id);

            foreach($plyr_id as $id)
                $insert = DB::query("insert into ".$game_table." (owner_id) values('".$id."')");        
        }   
    }
    
    public function post_new_player(){

       
        //  $mysqli->query("insert into players (plyr_id, first_name, last_name, start_date) values('".$_POST['id']."','".$_POST['fn']."','".$_POST['ln']."','".$date."')");
    }

    
    /********
     *Various procedural functions
     ************/

    private static function setInitArmies($plyrs){

        if($plyrs == 2)
            $init_armies = 40;
        elseif($plyrs == 3)
            $init_armies = 35;
        elseif($plyrs == 4)
            $init_armies = 30;
        elseif($plyrs == 5)
            $init_armies = 25;
        elseif($plyrs == 6)
            $init_armies = 20;

        return $init_armies;
    }
    
}



?>