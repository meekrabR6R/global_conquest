<?php
/********************************************************
* ------- Model class for all game tables --------------
********************************************************/
class GameTable{

    /*************************************************
    * Gets current state of territories (army amounts, 
    * owners, etc.) of current game.
    * @param $game_table - name of table of current
    * game territories
    ***************************************************/
	public static function getGameState($game_table){
            
            $check = DB::only('SELECT COUNT(*) as `exists`
                               FROM information_schema.tables
                               WHERE table_name IN (?)
                               AND table_schema = database()',$game_table);
            
            if(!$check){
                
                $new_table =  Schema::create($game_table, function($table){
                            $table->increments('id');
                            $table->string('continent');
                            $table->string('owner_id',20);
                            $table->integer('army_cnt')->default(1);
                        });

                Schema::table($game_table, function($table){

                    $table->foreign('owner_id')->references('plyr_id')->on('players');
                });

               // return $new_table;

            }
           // else {
                    
                return DB::query('select * from '. $game_table);       
          //  }
            
    }

    /****************************************************************************************
    * Updates territory army counts with value of armies placed at beginning of game or turn.
    * @param $game_table - table of territories for game
    * @param $armies - number of armies to place
    * @param terr_num - number of terr div in view
    * @param $game_id - ID number of game
    * @param $plyr_id - facebook ID of player
    *****************************************************************************************/
    public static function updateArmies($game_table, $armies, $terr_num, $game_id, $plyr_id){

        $select_armies = DB::query("select army_cnt from ".$game_table." where id= ? ",$terr_num+1);
        $new_count = $armies + $select_armies[0]->army_cnt;
        $bindings = array('armies' => $new_count, 'id' => $terr_num+1);
        $update_armies = DB::query("update ".$game_table." set army_cnt = ? where id= ?", $bindings);
   
        $curr_game = Plyrgames::where('game_id', '=', $game_id)->where('plyr_id', '=', $plyr_id)->first();
        $curr_initarmies = $curr_game->init_armies;
        $curr_game->init_armies = ($curr_initarmies - $armies);
        $curr_game->save();
    }

    /*****************************************************************************************
    * Updates army counts of attacker and defender territories during attack
    * @param $game_table - table of territories for current game
    * @param $attk_armies - number of armies in attacking territory
    * @param $def_armies - number of armies in defending territory
    * @param $def_id - ID of defending territory
    ******************************************************************************************/
    public static function attack($game_table, $attk_armies, $attk_id, $def_armies, $def_id){

    	$bindings = array('army_cnt' => $attk_armies, 'id' => $attk_id);
        DB::query('update '.$game_table.' set army_cnt = ? where id = ?', $bindings); 

        $bindings = array('army_cnt' => $def_armies, 'id' => $def_id);
        DB::query('update '.$game_table.' set army_cnt = ? where id = ?', $bindings);
    }

    /*********************************************************************************************
    * Updates owner ID and army count of defeated defending territory (owner ID shifts from defender's
    * ID to attacker's).
    * @param $game_table - table of territories for current game
    * @param $attk_armies - number of armies in attacking territory
    * @param $attk_id - ID of attacking territory
    * @param $attk_owner - ID of owner of attacking territory
    * @param $def_armies - number of armies in defending territory
    * @param $def_id - ID of defending territory
    **************************************************************************************************/
    public static function takeOver($game_table, $attk_armies, $attk_id, $attk_owner, $def_armies, $def_id){

	    $bindings = array('army_cnt' => $attk_armies, 'id' => $attk_id);
        DB::query('update '.$game_table.' set army_cnt = ? where id = ?', $bindings);

        $bindings = array('army_cnt' => $def_armies, 'id' => $def_id);
        DB::query('update '.$game_table.' set army_cnt = ? where id = ?', $bindings);

        $bindings = array('owner_id' => $attk_owner, 'id' => $def_id);
        DB::query('update '.$game_table.' set owner_id = ? where id = ?', $bindings);
    }

    /*******************************************************************************************
    * Updates army counts in 'from' and 'to' territories after 'end of turn' army move is executed.
    * @param
    **********************************************************************************************/
    public static function moveArmies($game_table, $from_id, $to_id, $from_amount, $to_amount){

        $bindings = array('army_cnt' =>  $from_amount, 'id' => $from_id);
        DB::query('update '.$game_table.' set army_cnt = ? where id = ?', $bindings);

        $bindings = array('army_cnt' =>  $to_amount, 'id' => $to_id);
        DB::query('update '.$game_table.' set army_cnt = ? where id = ?', $bindings);

    }

    /*************************************************************
    * Get number of territories owned by player
    *************************************************************/
    public static function getTerritoryNumber($game_id, $user_id){

        $game_table = 'game'.$game_id;
       
        $bindings = array('owner_id' => $user_id);
        return (int)DB::query('select count(owner_id) from '.$game_table.' where owner_id = ?', $bindings);
    }

}
?>