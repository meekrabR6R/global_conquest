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

    public static function getPlyrColor($player_data){
            
        $plyr_nm_color = array();
                
        foreach($player_data as $player){
                
                $plyr_index = DB::query('select players.plyr_id, plyr_color from plyr_games, players
                          where plyr_games.plyr_id = players.plyr_id
                          and plyr_games.plyr_id ='.$player->plyr_id);
                
                array_push($plyr_nm_color, $plyr_index);
        }
        
        return $plyr_nm_color;       
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