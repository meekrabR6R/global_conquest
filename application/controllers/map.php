<?php

    class Map_Controller extends Base_Controller{
        
        public $restful = true;
        
        /**************************************************
         * -----  RESTful functions -----
         *************************************************/
        
        public function get_map() {
           
            Asset::add('risk_style', 'css/risk_style.css');
            Asset::add('jquery', 'js/jquery20.js');
            Asset::add('chat', 'js/chat.js', 'jquery');
            Asset::add('new_chat', 'js/new_chat.js', 'jquery');
            Asset::add('graph', 'js/graph.js', 'jquery');
            Asset::add('territory_setter', 'js/territory_setter.js', 'jquery');
            Asset::add('attack', 'js/attack.js', 'jquery');
            Asset::add('move_armies', 'js/move_armies.js', 'jquery');
            Asset::add('make_game', 'js/make_game.js', 'jquery');
         
          
            $facebook = Map_Controller::getFB();
            $user = $facebook->api('/me');
            
            $game_id = $_GET['game_id'];

            $game = Games::where('game_id', '=', $game_id)->first();
            $game_maker = $game->maker_id;
           // $armies_plcd = $game->armies_plcd;

            $game_table = $game->title.''.$game_id;

            $maker_color = Plyrgames::where('plyr_id', '=', $game_maker)->first()->plyr_color;
            $plyr_data = Plyrgames::where('game_id','=', $game_id)->get();
            $plyr_count = Plyrgames::where('game_id','=', $game_id)->count();
            
            $plyr_fn = Map_Controller::getFirstNames($game_id);
            $plyr_nm_color = Map_Controller::getPlyrColor($plyr_data);

            $init_armies = Map_Controller::getInitArmies($user['id'], $plyr_data);
            $armies_plcd = Map_Controller::setArmiesPlcd($plyr_data);

            Map_Controller::setTurnOrder($armies_plcd, $game, $plyr_data);

            $join_flag = 0;
            foreach($plyr_data as $player){
                    if($user['id'] == $player->plyr_id)
                            $join_flag = 1;
            }
            
            $game_state = Map_Controller::makeGameTable($game_table);
            $player_up = Plyrgames::where('game_id','=', $game_id)->where('trn_active','=',1)->first();

            if($plyr_count == $game->plyrs){
                    
                    
                    return View::make('game_map')
                            ->with('game', $game)
                            ->with('plyr_data', $plyr_data)
                            ->with('plyr_fn', $plyr_fn)
                            ->with('join_flag', $join_flag)
                            ->with('plyr_count', $plyr_count)
                            ->with('uid', $user['id'])
                            ->with('user_fn', $user['first_name'])
                            ->with('game_state', $game_state)
                            ->with('plyr_nm_color', $plyr_nm_color)
                            ->with('game_maker', $game_maker)
                            ->with('maker_color', $maker_color)
                            ->with('armies_plcd', $armies_plcd)
                            ->with('init_armies', $init_armies)
                            ->with('game_table', $game_table)
                            ->with('player_up', $player_up);
                    
            }
            
            return View::make('game_map')
                    ->with('game', $game)
                    ->with('plyr_data', $plyr_data)
                    ->with('plyr_fn', $plyr_fn)
                    ->with('join_flag', $join_flag)
                    ->with('plyr_count', $plyr_count)
                    ->with('uid', $user['id'])
                    ->with('user_fn', $user['first_name'])
                    ->with('game_maker', $game_maker)
                    ->with('armies_plcd', $armies_plcd)
                    ->with('maker_color', $maker_color)
                    ->with('game_table', $game_table)
                    ->with('player_up', $player_up);
        }
        
        
        public function post_place(){

            $game_table = Input::get('game_table');
            $armies = Input::get('armies');
            $terr_num = Input::get('terr_num');
            $game_id = Input::get('game_id');
            $plyr_id = Input::get('uid');

            Map_Controller::updateArmies($game_table, $armies, $terr_num, $game_id, $plyr_id);
            $new_initarmies = Plyrgames::where('game_id', '=', $game_id)->where('plyr_id', '=', $plyr_id)->first()->init_armies;
            echo $new_initarmies;
        }



        /**************************************************
         * -----  Various Procedural Functions -----
         *---------(Likely candidates for model methods)---------
         *************************************************/
        private static function updateArmies($game_table, $armies, $terr_num, $game_id, $plyr_id){

            $select_armies = DB::query("select army_cnt from ".$game_table." where id= ? ",$terr_num+1);
            $new_count = $armies + $select_armies[0]->army_cnt;
            $bindings = array('armies' => $new_count, 'id' => $terr_num+1);
            $update_armies = DB::query("update ".$game_table." set army_cnt = ? where id= ?", $bindings);
       
            $curr_game = Plyrgames::where('game_id', '=', $game_id)->where('plyr_id', '=', $plyr_id)->first();
            $curr_initarmies = $curr_game->init_armies;
            $curr_game->init_armies = ($curr_initarmies - $armies);
            $curr_game->save();
        }

        private static function setArmiesPlcd($plyr_data){

            $set_flag = 0;
            foreach($plyr_data as $player){
                if($player->init_armies > 0)
                    $set_flag = 1;
            }

            if($set_flag == 0)
                return 1;
            else
                return 0;
        }

        private static function setTurnOrder($armies_plcd, $game, $plyr_data){

            if($armies_plcd == 1 && $game->turns_set == 0){

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
        }
        private static function makeGameTable($game_table){
            
            $check = DB::only('SELECT COUNT(*) as `exists`
                               FROM information_schema.tables
                               WHERE table_name IN (?)
                               AND table_schema = database()',$game_table);
            
            if(!$check){
                
                return  Schema::create($game_table, function($table){
                            $table->increments('id');
                            $table->string('curr_owner');
                            $table->integer('army_cnt')->default(1);
                    });
            }
            else {
                    
                return DB::query('select * from '. $game_table);       
            }
            
        }
        
        private static function getPlyrColor($player_data){
            
            $plyr_nm_color = array();
                    
            foreach($player_data as $player){
                    
                    $plyr_index = DB::query('select first_name, plyr_color from plyr_games, players
                              where plyr_games.plyr_id = players.plyr_id
                              and plyr_games.plyr_id ='.$player->plyr_id);
                    
                    array_push($plyr_nm_color, $plyr_index);
            }
            
            return $plyr_nm_color;       
        }

        private static function getFirstNames($game_id){

            $plyr_fn = array();
            $plyr_fn_qry = DB::query('select first_name from players, plyr_games where plyr_games.plyr_id = players.plyr_id and plyr_games.game_id = '.$game_id);
            
            foreach($plyr_fn_qry as $player)
                    array_push($plyr_fn, $player->first_name);

            return $plyr_fn;
        }

        private static function getInitArmies($user_id, $plyr_data){
         
            foreach($plyr_data as $player){
                    if($user_id == $player->plyr_id){
                        return $player->init_armies; 
                      
                    }     
            }
        }
    }
    
?>