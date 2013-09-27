<?php
class Players extends Eloquent{
    
/**
* The database table used by the model.
*
* @var string
*/
    public static $table = 'players';
    public static $key = 'plyr_id';

    public static function getLeaderBoardStats() {
    	  $players = Players::all();
        $stats = array();

        foreach($players as $player) {
      	    $player_stat['total'] = ($player->two_win*2) + ($player->three_win*3) +
      	    ($player->four_win*4) + ($player->five_win*5) + ($player->six_win*6);
      	    $player_stat['player'] = $player;
            array_push($stats, $player_stat);
        }
        rsort($stats);
        return $stats;
    }

}

?>