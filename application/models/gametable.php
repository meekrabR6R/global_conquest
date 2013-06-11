<?php

class GameTable{

	public static function getGameState($game_table){
            
            $check = DB::only('SELECT COUNT(*) as `exists`
                               FROM information_schema.tables
                               WHERE table_name IN (?)
                               AND table_schema = database()',$game_table);
            
            if(!$check){
                
                $new_table =  Schema::create($game_table, function($table){
                            $table->increments('id');
                            $table->string('owner_id');
                            $table->integer('army_cnt')->default(1);
                        });

                Schema::table($game_table, function($table){

                    $table->foreign('owner_id')->references('plyr_id')->on('players');
                });

                return $new_table;

            }
            else {
                    
                return DB::query('select * from '. $game_table);       
            }
            
    }

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


    public static function attack($game_table, $attk_armies, $attk_id, $def_armies, $def_id){

    	$bindings = array('army_cnt' => $attk_armies, 'id' => $attk_id);
        DB::query('update '.$game_table.' set army_cnt = ? where id = ?', $bindings); 

        $bindings = array('army_cnt' => $def_armies, 'id' => $def_id);
        DB::query('update '.$game_table.' set army_cnt = ? where id = ?', $bindings);
    }


    public static function takeOver($game_table, $attk_armies, $attk_id, $attk_owner, $def_armies, $def_id){

	    $bindings = array('army_cnt' => $attk_armies, 'id' => $attk_id);
        DB::query('update '.$game_table.' set army_cnt = ? where id = ?', $bindings);

        $bindings = array('army_cnt' => $def_armies, 'id' => $def_id);
        DB::query('update '.$game_table.' set army_cnt = ? where id = ?', $bindings);

        $bindings = array('owner_id' => $attk_owner, 'id' => $def_id);
        DB::query('update '.$game_table.' set owner_id = ? where id = ?', $bindings);
    }
}
?>