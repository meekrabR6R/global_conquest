<?php

    class Map_Controller extends Base_Controller{
        
        public $restful = true;
        
        /**************************************************
         * -----  RESTful functions -----
         *************************************************/
        
        /**************************************************
        * Returns map view for selected game. !!Needs some
        * work!!
        **************************************************/
        public function get_map() {
           
            $facebook = Map_Controller::getFB();
            $uid = $facebook->getUser();

            if($uid){
                try{
                    Asset::add('risk_style', 'css/risk_style.css');
                    Asset::add('jquery', 'js/libs/jquery20.js');
                    Asset::add('graph', 'js/map/graph.js', 'jquery');
                    Asset::add('territory_setter', 'js/map/territory_setter.js', 'jquery');
                    Asset::add('attack', 'js/map/attack.js', 'jquery');
                    Asset::add('move_armies', 'js/map/move_armies.js', 'jquery');
                    Asset::add('make_game', 'js/map/make_game.js', 'jquery');
                 
                    $facebook = Map_Controller::getFB();
                    $user = $facebook->api('/me');
                    
                    $game_id = $_GET['game_id'];

                    $game = Games::where('game_id', '=', $game_id)->first();
                    $game_maker = $game->maker_id;

                    $game_table = $game->title.''.$game_id;
                    $card_table = 'cards'.$game_id;

                    $maker_color = Plyrgames::where('plyr_id', '=', $game_maker)->first()->plyr_color;
                    $plyr_data = Plyrgames::where('game_id','=', $game_id)->get();
                    $plyr_count = Plyrgames::where('game_id','=', $game_id)->count();
                    
                    $plyr_fn = Plyrgames::getFirstNames($game_id);
                    $plyr_nm_color = Plyrgames::getPlyrColor($plyr_data, $game_id);

                    $init_armies = Map_Controller::getInitArmies($user['id'], $plyr_data);
                    $armies_plcd = Map_Controller::setArmiesPlcd($plyr_data);

                    if($armies_plcd == 1 && $game->turns_set == 0)
                        Plyrgames::setTurnOrder($game, $game_id, $plyr_data, $plyr_count);

                    $join_flag = 0;
                    foreach($plyr_data as $player){
                            if($user['id'] == $player->plyr_id)
                                    $join_flag = 1;
                    }
                    
                    $game_state = GameTable::getGameState($game_table);
                    $card_state = CardTable::getCardTableState($card_table);

                    $player_up = Plyrgames::where('game_id','=', $game_id)->where('trn_active','=',1)->first();

                    //these returns suck.....refactor ASAP!
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
                                    ->with('card_table', $card_table)
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
                            ->with('init_armies', $init_armies)
                            ->with('game_table', $game_table)
                            ->with('card_table', $card_table)
                            ->with('player_up', $player_up);
                }
                catch(FacebookApiException $e){
                    $user = null;
                }

            }
            else{
                $login = $facebook->getLoginUrl();
                echo '<a href="'.$login.'">LOGIN!</a>';
            }
        }
        
        
        public function post_place(){

            $game_table = Input::get('game_table');
            $armies = Input::get('armies');
            $terr_num = Input::get('terr_num');
            $game_id = Input::get('game_id');
            $plyr_id = Input::get('uid');

            GameTable::updateArmies($game_table, $armies, $terr_num, $game_id, $plyr_id);
            $new_initarmies = Plyrgames::where('game_id', '=', $game_id)->where('plyr_id', '=', $plyr_id)->first()->init_armies;
            echo $new_initarmies;
        }


        public function post_attack(){

            $game_table = Input::get('game_table');
            $attk_armies = Input::get('attk_armies');
            $def_armies = Input::get('def_armies');
            $attk_id = Input::get('attk_id');
            $def_id = Input::get('def_id');

            GameTable::attack($game_table, $attk_armies, $attk_id, $def_armies, $def_id);
        }

        public function post_take_over(){

            $game_table = Input::get('game_table');
            $attk_armies = Input::get('attk_armies');
            $def_armies = Input::get('def_armies');
            $attk_id = Input::get('attk_id');
            $def_id = Input::get('def_id');
            $attacker_id = Input::get('attacker_id');
           
            GameTable::takeOver($game_table, $attk_armies, $attk_id, $attacker_id, $def_armies, $def_id);

        }

       public function post_make_card(){
    
            $game_id = Input::get('game_id');
            $card_table = Input::get('card_table');
            $owner_id = Input::get('owner_id');
            $army_type = Input::get('army_type');
            $terr_id = Input::get('terr_id');

            CardTable::insert_card($card_table, $owner_id, $army_type, $terr_id);
            $game = Plyrgames::where('game_id', '=', $game_id)->where('plyr_id','=', $owner_id)->first();
            $game->got_card = 1;
            $game->save();

       }

   
        /**********************************************
        * Checks 'got_card' status (0 for no, 1 for yes)
        * for players current turn based on owner_id and
        * game id received from client. It then echoes 
        * back the status to the client. (0 or 1).
        ************************************************/
        public function get_card_status(){

            $owner_id = Input::get('owner_id');
            $game_id = Input::get('game_id');
            $got_card = Plyrgames::where('plyr_id', '=', $owner_id)->where('game_id', '=', $game_id)->first()->got_card;

            echo json_encode(array('owner_id' => $owner_id, 'got_card' => $got_card));

        }


        /***********************************************
        * Updates army counts in territories in which
        * armies were removed and added during end of
        * turn army moves
        ************************************************/
        public function post_move_armies(){

            $game_table = Input::get('game_table');
            $game_id = Input::get('game_id');
            $user_id = Input::get('user_id');
            $from_id = Input::get('from_id');
            $to_id = Input::get('to_id');
            $from_amount = Input::get('from_amount');
            $to_amount = Input::get('to_amount');

            GameTable::moveArmies($game_table, $from_id, $to_id, $from_amount, $to_amount);
            Plyrgames::nextTurn($user_id, $game_id);
        }

        /**************************************************
         * -----  Various Procedural Functions -----
         *---------(Likely candidates for model methods)---------
         *************************************************/
        

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

        
        private static function getInitArmies($user_id, $plyr_data){
         
            foreach($plyr_data as $player){
                if($user_id == $player->plyr_id){
                    return $player->init_armies; 
                  
                }
            }
        }
    }
    
?>