<?php

    class Map_Controller extends Base_Controller{
        
        public $restful = true;
        
        private $game;
        private $game_id;
        private $game_title;
        private $game_maker;
        private $game_table;
        private $game_state;
        private $plyr_data; //rename this shit
        private $plyr_count;
        private $plyr_limit;
        private $player_list;
        private $plyr_nm_color;//rename this too!
        private $armies_plcd;
        private $join_flag;
        private $init_armies;
        private $player_cards;
        private $player_up;
        private $uid;
        private $facebook;

        //constructor
        public function __construct(){

            $this->facebook = Map_Controller::getFB();
            $this->uid = $this->facebook->getUser();

            $this->game_id = $_GET['game_id'];
            $this->game = new CurrentGame($this->game_id);
            $this->game_title    = $this->game->getTitle();
            $this->game_maker    = $this->game->getGameMaker();
            $this->game_table    = $this->game->getTableName();
            $this->game_state    = $this->game->getGameState();
            $this->plyr_data     = $this->game->getPlayers(); //rename this shit
            $this->plyr_count    = $this->game->getPlayerCount();
            $this->plyr_limit    = $this->game->getPlayerLimit();
            $this->player_list   = $this->game->getPlayerList();
            $this->plyr_nm_color = $this->game->getPlayerColors();//rename this too!
            $this->armies_plcd   = $this->game->armiesPlaced();
            $this->join_flag     = $this->game->isMember($this->uid);
            $this->init_armies   = $this->game->getInitArmies($this->uid);
            $this->player_cards  = $this->game->getHand($this->uid);
            $this->player_up     = $this->game->getUpPlayer();
        }

        /**************************************************
         * -----  RESTful functions -----
         *************************************************/
        
        /**************************************************
        * Returns map view for selected game. !!Needs some
        * work!!
        **************************************************/
        public function get_map() {
           
            //$facebook = Map_Controller::getFB();
            //$uid = $facebook->getUser();

            if($this->uid){
                try{
                    Asset::add('risk_style', 'css/risk_style.css');
                    Asset::add('jquery', 'js/libs/jquery20.js');
                    Asset::add('graph', 'js/map/graph.js', 'jquery');
                    Asset::add('territory_setter', 'js/map/territory_setter.js', 'jquery');
                    Asset::add('attack', 'js/map/attack.js', 'jquery');
                    Asset::add('move_armies', 'js/map/move_armies.js', 'jquery');
                    Asset::add('make_game', 'js/map/make_game.js', 'jquery');

                 
                    //$facebook = Map_Controller::getFB();
                    $user = $this->facebook->api('/me');
                    
                    //this is stupid and needs to be changed.
                    $maker_color = Plyrgames::where('plyr_id', '=', $this->game_maker)->first()->plyr_color; 
                    $card_table = 'cards'.$this->game_id; //temporary!
                    
                    return View::make('game_map')   
                        ->with('game', $this->game)
                        ->with('game_id', $this->game_id)
                        ->with('game_title', $this->game_title)
                        ->with('plyr_limit', $this->plyr_limit)
                        ->with('plyr_data', $this->plyr_data)
                        ->with('plyr_fn', $this->player_list)
                        ->with('join_flag', $this->join_flag)
                        ->with('plyr_count', $this->plyr_count)
                        ->with('uid', $user['id'])
                        ->with('user_fn', $user['first_name'])
                        ->with('game_state', $this->game_state)
                        ->with('plyr_nm_color', $this->plyr_nm_color)
                        ->with('game_maker', $this->game_maker)
                        ->with('maker_color', $maker_color)
                        ->with('armies_plcd', $this->armies_plcd)
                        ->with('init_armies', $this->init_armies)
                        ->with('game_table', $this->game_table)
                        ->with('card_table', $card_table)
                        ->with('player_cards', $this->player_cards)
                        ->with('player_up', $this->player_up);

                      
                }
                catch(FacebookApiException $e){
                    $user = null;
                }

            }
            else{
                $login = $this->facebook->getLoginUrl();
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
            $terr_name = Input::get('terr_name');

            CardTable::insert_card($card_table, $owner_id, $army_type, $terr_name);
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
        * Checks if cards are valid for turn in
        ************************************************/
        public function post_card_turn_in(){

            $owner_id = Input::get('owner_id');
            $cards = Input::get('data');
            $turn_in = $this->game->isTurnIn($cards);
            if($turn_in)
                echo $this->game->turnInCards($owner_id, $cards);


        }

        public function get_test(){

            $cards = [['name' => 'a', 'value' => 'Infantry'], ['name' => 'b', 'value' => 'Cavalry'], ['name' => 'c', 'value' => 'Cannon']];

            if($this->game->isTurnIn($cards))
                echo 'turn in!';
            else
                echo 'nope';
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

        /***************************************************
        * Ends turn and passes turn to next player
        ****************************************************/
        public function post_end_turn(){

            $user_id = Input::get('user_id');
            $game_id = Input::get('game_id');
            Plyrgames::nextTurn($user_id, $game_id);
        }

    }
    
?>