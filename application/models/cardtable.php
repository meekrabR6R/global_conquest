<?php
class CardTable{
	
    /****************************************************
    * Gets state of card table for game. If table does 
    * not yet exist, it creates a new card table.
    * @param  $card_table - name of card table ('cards+game_id')
    * @return $new_table - if table doesn't yet exist
    * @return current state of table
    ******************************************************/ 
	public static function getCardTableState($card_table){
            
            $check = DB::only('SELECT COUNT(*) as `exists`
                               FROM information_schema.tables
                               WHERE table_name IN (?)
                               AND table_schema = database()',$card_table);
            
            if(!$check){
                
                $new_table = Schema::create($card_table, function($table){
                                $table->increments('id');
                                $table->string('owner_id');
                                $table->string('army_type');
                                $table->string('terr_name');
                            });

                Schema::table($card_table, function($table){

                    $table->foreign('owner_id')->references('plyr_id')->on('players');
                });

                return $new_table;

            }
            else {
                    
                return DB::query('select * from '. $card_table);       
            }
            
    }

    //inserts card into table
    public static function insert_card($card_table, $owner_id, $army_type, $terr_name){

        $bindings = array('owner_id' => $owner_id, 'army_type' => $army_type, 'terr_name' => $terr_name);
        DB::query("insert into ".$card_table." (owner_id, army_type, terr_name) values(?, ?, ?)",$bindings);
    }

    //get number of cards
    public static function getNumberOfCards($user_id, $card_table){

        $bindings = array('owner_id' => $user_id);
        return  DB::query('select count(owner_id) as count from '.$card_table.' where owner_id = ?', $bindings)[0]->count;

    }

    //check if turn in
    public static function checkTurnIn($owner_id, $card_table){

        $check_key = ['Infantry', 'Cavalry', 'Cannon'];
        $bindings = array('owner_id' => $owner_id);
        $cards = DB::query('select army_type, terr_name from '.$card_table.' where owner_id = ?', $bindings);

        $types = array();
        foreach($cards as $card)
            array_push($types, $card->army_type);
        
        $result = array_diff($check_key, $types);
        if(count($result) == 0)
            return 1;
        else
            return $result;
        
    }
}
?>