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
            
            //facebook logic needs to be modularized! BUT HOW!!?
            $config = array();
            $config['appId'] = AppInfo::appID();
            $config['secret'] = AppInfo::appSecret();
            $facebook = new Facebook($config);
            $user = $facebook->api('/me');
            
            $game_id = $_GET['game_id'];
            $game = Games::where('game_id', '=', $game_id)->first();
            $game_table = $game->title.''.$game_id;
            
            $plyr_id = Plyrgames::where('game_id','=', $game_id)->get();
            $plyr_count = Plyrgames::where('game_id','=', $game_id)->count();
            $plyr_fn_qry = DB::query('select first_name from players, plyr_games where plyr_games.plyr_id = players.plyr_id');
            
            
            $plyr_fn = array();
            
            $join_flag = 0;
            $fn_addflag = 0;
            
            foreach($plyr_fn_qry as $player)
                    array_push($plyr_fn, $player->first_name);
            
            foreach($plyr_id as $player){
                    if($user['id'] == $player->plyr_id)
                            $join_flag = 1;
            }
            
            $game_state = Map_Controller::makeGameTable($game_table);
            
            if($plyr_count == $game->plyrs){
                    
                   $plyr_nm_color = Map_Controller::getPlyrColor($plyr_id);
                    
                    
                    return View::make('game_map')
                            ->with('game', $game)
                            ->with('plyr_id', $plyr_id)
                            ->with('plyr_fn', $plyr_fn)
                            ->with('join_flag', $join_flag)
                            ->with('plyr_count', $plyr_count)
                            ->with('uid', $user['id'])
                            ->with('user_fn', $user['first_name'])
                            ->with('game_state', $game_state)
                            ->with('plyr_nm_color', $plyr_nm_color);
                    
            }
            
            return View::make('game_map')
                    ->with('game', $game)
                    ->with('plyr_id', $plyr_id)
                    ->with('plyr_fn', $plyr_fn)
                    ->with('join_flag', $join_flag)
                    ->with('plyr_count', $plyr_count)
                    ->with('uid', $user['id'])
                    ->with('user_fn', $user['first_name']);
        }
        
        
        /**************************************************
         * -----  Various Procedural Functions -----
         *************************************************/
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
        
        private static function getPlyrColor($player_id){
            
            $plyr_nm_color = array();
                    
            foreach($player_id as $player){
                    
                    $plyr_index = DB::query('select first_name, plyr_color from plyr_games, players
                              where plyr_games.plyr_id = players.plyr_id
                              and plyr_games.plyr_id ='.$player->plyr_id);
                    
                    array_push($plyr_nm_color, $plyr_index);
            }
            
            return $plyr_nm_color;       
        }
    }
    
?>