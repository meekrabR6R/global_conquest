<?php

class Plyrgames extends Eloquent{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    public static $table = 'plyr_games';
    public static $key = 'plyr_games_id';

  
    //updates turn armies for next player
    public static function updateTurnArmies($game_id, $plyr_id){
        
        $turn_armies = Plyrgames::getTurnArmies($game_id, $plyr_id);

        $bindings = array('init_armies' => $turn_armies, 'plyr_id' => $plyr_id ,'game_id' => $game_id);
        $update_armies = DB::query('update plyr_games set init_armies = ? where plyr_id = ? and game_id = ?', $bindings);

        $bindings = array('plyr_id' => $plyr_id, 'game_id' => $game_id);
        $update_set_army = DB::query('update plyr_games set turn_armies_set = 1 where plyr_id = ? and game_id = ?', $bindings);
    }

    //adds continent 
    public static function addContinentArmies($owner_id, $game_id, $armies){

        $curr_player = Plyrgames::where('plyr_id', '=', $owner_id)->where('game_id', '=', $game_id)->first();
        $curr_init_armies = $curr_player->init_armies;
        $curr_player->init_armies = $curr_init_armies + $armies;
        $curr_player->save();

        $curr_player->turn_armies_set = true;
        $curr_player->save();
    }

    //get turn armies
    public static function getTurnArmies($game_id, $user_id){

        $game_table = 'game'.$game_id;

        $bindings = array('owner_id' => $user_id);
        $terrs = DB::query('select count(owner_id) as count from '.$game_table.' where owner_id = ?', $bindings);
        $terr_count = $terrs[0]->count;

        
        $turn_armies = $terr_count / 3;

        if($turn_armies < 3)
            $turn_armies = 3;

        return $turn_armies;
    }

     /*****************************************************
    * Checks terr counts for attacker/defender. If attacker
    * terr count = 42, s/he is declared winner. If defender
    * terr count = 0, s/he is declared defeated.
    ********************************************************/
    public static function checkTerrCounts($game_id, $attk_owner, $def_owner, $territory_count){

        if($territory_count['attk_terr'] == 42){
           
            $attacker = Plyrgames::where('game_id', '=', $game_id)->where('plyr_id', '=', $attk_owner)->first();
            $attacker->winner = true;
            $attacker->save();
            
            $winner = Players::where('plyr_id', '=', $attacker->plyr_id)->first();
            $message = 'Comrade '.$winner->first_name.' is victorious!';
            Plyrgames::notifyAll($game_id, $message);
        }

        if($territory_count['def_terr'] == 0){
           
            $victor = Players::where('plyr_id', '=', $attk_owner)->first();
            $victor->kill_count = $victor->kill_count + 1;
            $victor->save();

            $defender = Plyrgames::where('game_id', '=', $game_id)->where('plyr_id', '=', $def_owner)->first();
            $defender->defeated = 1;
            $defender->save();
            
            $bindings = array('attk_owner' => $attk_owner, 'def_owner' => $def_owner);
            DB::query('update cards'.$game_id.' set owner_id = ? where owner_id = ?', $bindings);
            
            $loser = Players::where('plyr_id', '=', $defender->plyr_id)->first();
            $message = 'Comrade '.$loser->first_name.' has fallen in battle..'; 
            Plyrgames::notifyAll($game_id, $message); 
        }
    }

    private static function sendNotification($player_id, $message){
        $facebook = CurrentGame::getFB();

        $data = array(
            'href' => 'https://globalconq-meekrab.rhcloud.com/',
            'access_token' => $facebook->getAppId() . '|' . $facebook->getApiSecret(),
            'template' => $message
        );

        try {
            $test = $facebook->api("/".$player_id."/notifications", 'POST', $data);
        } catch (FacebookApiException $e){}
    }

    private static function notifyAll($game_id, $message) {
        $players = Plyrgames::where('game_id', '=', $game_id)->get();

        foreach($players as $player) {
            Plyrgames::sendNotification($player->plyr_id, $message);
        }
    }
    
}

?>