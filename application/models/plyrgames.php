<?php

class Plyrgames extends Eloquent{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    public static $table = 'plyr_games';
    public static $key = 'plyr_games_id';

    public static function getFirstNames($game_id){

        $plyr_fn = array();
        $plyr_fn_qry = DB::query('select first_name from players, plyr_games where plyr_games.plyr_id = players.plyr_id and plyr_games.game_id = '.$game_id);
        
        foreach($plyr_fn_qry as $player)
                array_push($plyr_fn, $player->first_name);

        return $plyr_fn;
    }

	public static function setTurnOrder($game, $game_id, $plyr_data, $plyr_count){

        $turns = array();
        for($i=1; $i<=$plyr_count; $i++)
            array_push($turns, $i);

        shuffle($turns);
       
        $i = 0;
        foreach($plyr_data as $plyr){
            $plyr->turn = $turns[$i++];
            $plyr->save();
        }
        
        $game->turns_set = 1;
        $game->save();

        $player_one = Plyrgames::where('game_id','=', $game_id)->where('turn','=',1)->first();
        $player_one->trn_active = 1;
        $player_one->save();
        
    }

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

        
        $bindings = array('game_id' => $game_id, 'plyr_id' => $user_id);
        $pass_turn = DB::query('update plyr_games set trn_active = 0 where game_id = ? and plyr_id = ?', $bindings);
        $reset_cards = DB::query('update plyr_games set got_card = 0 where game_id = ? and plyr_id = ?', $bindings);
        
        $turn_armies = Plyrgames::getTurnArmies($game_id, $user_id);

        $bindings = array('init_armies' =>$turn_armies, 'plyr_id' => $user_id, 'game_id' => $game_id);
        $update_armies = DB::query('update plyr_games set init_armies = ? where plyr_id = ? and game_id = ?', $bindings);

        $next_plyr = Plyrgames::where('game_id', '=', $game_id)->where('turn', '=', $next_turn)->first();
        $next_plyr->trn_active = 1;
        $next_plyr->save();
        
       
        //reset card status here..
    }

    public static function getTurnArmies($game_id, $user_id){

        $game_table = 'game'.$game_id;

        $bindings = array('owner_id' => $user_id);
        $terr_count = (int)DB::query('select count(owner_id) from '.$game_table.' where owner_id = ?', $bindings);
        $turn_armies = $terr_count / 3;

        var_dump($turn_armies);
        die();
        //consider factoring in continent bullshit here..
        return $turn_armies;
    }
    /*************************************************************
    *Checks status of 'got_card' bit in plyr_games table to see if
    *player has already received a card during his/her current turn.
    *@param: $owner_id: facebook id of current player
    *@param: $game_id: id of game
    *@return: value of 'got_card' bit (0 for no card received, 1 for
    *card received).
    *************************************************************/
    public static function getPlyrCardStatus($owner_id, $game_id){
        

    }
    
}

?>