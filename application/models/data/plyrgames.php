<?php

class Plyrgames extends Eloquent{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    public static $table = 'plyr_games';
    public static $key = 'plyr_games_id';

    /**********************************************
    * Gets list of players' first names
    ***********************************************/
    public static function getFirstNames($game_id){

        $plyr_fn = array();
        $plyr_fn_qry = DB::query('select first_name from players, plyr_games where plyr_games.plyr_id = players.plyr_id and plyr_games.game_id = '.$game_id);
        
        foreach($plyr_fn_qry as $player)
                array_push($plyr_fn, $player->first_name);

        return $plyr_fn;
    }

	
    /*********************************************************
    * Gets player's color
    * @param $player_data - single player record from db
    * @param $game_id - int id value for game
    * @return $plyr_nm_color - player id and color
    **********************************************************/
    public static function getPlyrColor($player_data, $game_id){
            
        $plyr_nm_color = array();
           
        foreach($player_data as $player){
                $bindings = array('plyr_games.plyr_id' => $player->plyr_id, 'game_id' => $game_id);
                $plyr_index = DB::query('select players.plyr_id, plyr_color from plyr_games, players
                          where plyr_games.plyr_id = players.plyr_id
                          and plyr_games.plyr_id = ?
                          and game_id = ?', $bindings);
                
                array_push($plyr_nm_color, $plyr_index);
        }
        
        return $plyr_nm_color;       
    }

    /*************************************************************
    * Transfers active turn status to next player in turn queue.
    **************************************************************/
    public static function nextTurn($user_id, $game_id){

        $curr_plyr = Plyrgames::where('plyr_id', '=', $user_id)->where('game_id', '=', $game_id)->first();
        $curr_turn = $curr_plyr->turn;
        
        $tot_plyrs = Games::where('game_id', '=',$game_id)->first()->plyrs;

        if($curr_turn < $tot_plyrs)
            $next_turn = $curr_turn + 1;
        else
            $next_turn = 1;

        //sets current player (who is ending turn)  in queue to 'inactive'
        $bindings = array('game_id' => $game_id, 'plyr_id' => $user_id);
        $pass_turn = DB::query('update plyr_games set trn_active = 0 where game_id = ? and plyr_id = ?', $bindings);
        $reset_cards = DB::query('update plyr_games set got_card = 0 where game_id = ? and plyr_id = ?', $bindings);
        
        
        //sets next player in queue to 'active'
        $next_plyr = Plyrgames::where('game_id', '=', $game_id)->where('turn', '=', $next_turn)->first();
        $next_plyr->trn_active = 1;
        $next_plyr->save();
        
         //reset card status here..
        $turn_armies = Plyrgames::getTurnArmies($game_id, $next_plyr->plyr_id);

        $bindings = array('init_armies' => $turn_armies, 'plyr_id' => $next_plyr->plyr_id, 'game_id' => $game_id);
        $update_armies = DB::query('update plyr_games set init_armies = ? where plyr_id = ? and game_id = ?', $bindings);
       
    }

    //get turn armies
    public static function getTurnArmies($game_id, $user_id){

        $game_table = 'game'.$game_id;

        $bindings = array('owner_id' => $user_id);
        $terr_count = DB::query('select count(owner_id) as count from '.$game_table.' where owner_id = ?', $bindings)[0]->count;
        
        $turn_armies = $terr_count / 3;

        if($turn_armies < 3)
            $turn_armies = 3;

        //consider factoring in continent bullshit here..
        return $turn_armies;
    }
    
}

?>