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
      	                            ($player->four_win*4) + ($player->five_win*5) + 
                                    ($player->six_win*6) +
            $player->kill_count;
            $player_stat['player'] = $player;
            array_push($stats, $player_stat);
        }
        rsort($stats);
        return $stats;
    }

    public static function updateLeaderboardStats($plyr_id) {

        $curr_game = Games::where('game_id', '=',$_GET['game_id'])->first();
        $player = Players::where('plyr_id', '=', $plyr_id)->first();
      
        switch($curr_game->plyrs) {
            case 2:
                $player->two_win = $player->two_win + 1;   
                break;
            case 3:
                $player->three_win = $player->three_win + 1;      
                break;
            case 4:
                $player->four_win = $player->four_win + 1;      
                break;
            case 5:
                $player->five_win = $player->five_win + 1;      
                break;
            case 6:
                $player->six_win = $player->six_win + 1;      
                break;
        }
        $player->save();

        $curr_game->active = false;
        $curr_game->save();
    }

}

?>