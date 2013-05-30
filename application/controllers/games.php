<?php

class Games_Controller extends Base_Controller{
    
    public $restful = true;

    public function get_games(){
     
        $mysqli = new mysqli('localhost', 'root', null, 'global_conq');
        
        $result = $mysqli->query("select * from games");//finetune this
        var_dump($result->fetch_all());
         
        $mysqli->close();

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
            'plyr_color' => Input::get('plyr_color')
        );
        
        if($plyr_count < $game->plyrs){
            Plyrgames::create($plyr_join);
            $plyr_count++;
        }
        
        if($plyr_count == $game->plyrs){
            $tot_players = DB::query('select first_name from players, plyr_games 
                          where  players.plyr_id = plyr_games.plyr_id
                          and plyr_games.game_id = ?', $game_id);
            
            $plyr_name = array();
            $index = 0;
            for($i = 0; $i <= 41; $i++){
                array_push($plyr_name, $tot_players[$index++]->first_name);
                if($index == $plyr_count)
                    $index = 0;
            }
            
            shuffle($plyr_name);
            foreach($plyr_name as $name)
                $insert = DB::query("insert into ".$game_table." (curr_owner) values('".$name."')");        
        }   
    }
    
    public function post_new_player(){

       
              //  $mysqli->query("insert into players (plyr_id, first_name, last_name, start_date) values('".$_POST['id']."','".$_POST['fn']."','".$_POST['ln']."','".$date."')");
    }
    
}



?>