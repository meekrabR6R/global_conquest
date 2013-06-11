<?php
class CardTable{
	
	public static function getCardTableState($card_table){
            
            $check = DB::only('SELECT COUNT(*) as `exists`
                               FROM information_schema.tables
                               WHERE table_name IN (?)
                               AND table_schema = database()',$card_table);
            
            if(!$check){
                
                $new_table = Schema::create($card_table, function($table){
                                $table->increments('id');
                                $table->string('owner_id');
                                $table->integer('army_type');
                                $table->integer('terr_id');
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

    public static function insert_card($card_table, $owner_id, $army_type, $terr_id){

        DB::query('insert into '.$card_table.' (owner_id, army_type, terr_id) values('.$owner_id.', '.$army_type.', '.$terr_id.')');
    }
}
?>