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
        private $winner;
        private $winner_name;
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
            $this->player_list   = $this->game->getPlayerNames();
            $this->plyr_nm_color = $this->game->getPlayerColors();//rename this too!
            $this->armies_plcd   = $this->game->armiesPlaced();
            $this->init_placed   = $this->game->startArmiesPlaced();
            $this->temp_takeover = $this->game->getTempTakeOver();
            //maybe player class?
            $this->join_flag     = $this->game->isMember($this->uid);
            $this->init_armies   = $this->game->getInitArmies($this->uid);
            $this->player_cards  = $this->game->getHand($this->uid);
            $this->player_up     = $this->game->getUpPlayer();
            $this->winner        = $this->game->getWinner();
            $this->winner_name   = $this->winner->getName();
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
                    Asset::add('place_armies', 'js/map/place_armies.js', 'jquery');
                    //Asset::add('continent_check', 'js/map/continent_check.js', 'jquery');

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
                        ->with('init_armies_placed', $this->init_placed)
                        ->with('armies_plcd', $this->armies_plcd)
                        ->with('init_armies', $this->init_armies)
                        ->with('game_table', $this->game_table)
                        ->with('card_table', $card_table)
                        ->with('player_cards', $this->player_cards)
                        ->with('player_up', $this->player_up)
                        ->with('temp_take_over', $this->temp_takeover)
                        ->with('winner', $this->winner);

                      
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

            $armies = Input::get('armies');
            $terr_num = Input::get('terr_num');
            $plyr_id = Input::get('uid');

            $new_initarmies = $this->game->placeArmies($plyr_id, $armies, $terr_num);
            echo $new_initarmies;
        }


        public function post_attack(){

            $game_table = Input::get('game_table');
            $attk_owner = Input::get('attk_owner');
            $def_owner = Input::get('def_owner');
            $attk_armies = Input::get('attk_armies');
            $def_armies = Input::get('def_armies');
            $attk_id = Input::get('attk_id');
            $def_id = Input::get('def_id');
            //maybe need to shift terrcount shit to post_take_over..
            echo json_encode($this->game->attack($attk_owner, $def_owner, $attk_armies, $attk_id, $def_armies, $def_id));
        }

        public function post_terr_taken(){
            
            $attk_terr = Input::get('attk_terr');
            $def_terr = Input::get('def_terr');
            $attk_armies = Input::get('attk_armies');

            $this->game->saveTakeOverState($attk_terr, $def_terr, $attk_armies);
        }

        public function post_take_over(){

            $game_table = Input::get('game_table');
            $attk_armies = Input::get('attk_armies');
            $def_armies = Input::get('def_armies');
            $attk_id = Input::get('attk_id');
            $def_id = Input::get('def_id');
            $attk_owner = Input::get('attacker_id');
            $def_owner = Input::get('defender_id');

            $this->game->unSaveTakeOverState();

            echo json_encode($this->game->takeOver($attk_owner, $def_owner, $attk_id, $def_id, $attk_armies, $def_armies));

        }

        public function post_make_card(){
    
            $owner_id = Input::get('owner_id');
            $army_type = Input::get('army_type');
            $terr_name = Input::get('terr_name');

            $this->game->awardCard($this->uid, $army_type, $terr_name);

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

        /***************************************************
        * Process continent bonuses
        ****************************************************/
        public function post_continent_bonuses(){


            $armies = Input::get('continent_bonuses');

            echo Plyrgames::addContinentArmies($this->uid, $this->game_id, $armies);
            
        }

        public function get_test(){

            $taken_colors = Plyrgames::where('game_id', '=', $this->game_id)->get();

            $colors = array();
            foreach($taken_colors as $color){
                array_push($colors, $color->plyr_color);
            }
            echo json_encode($colors);
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

            $this->game->moveArmies($user_id, $from_id, $to_id, $from_amount, $to_amount);
        }

        /***************************************************
        * Ends turn and passes turn to next player
        ****************************************************/
        public function post_end_turn(){

            $user_id = Input::get('user_id');
            $game_id = Input::get('game_id');
           
            $this->game->nextTurn($user_id);
        }

        /************************************************
        * Check what colors have been taken and returns
        * available colors
        ************************************************/
        public function get_colors(){

            $taken_colors = Plyrgames::where('game_id', '=', $this->game_id)->get();

            $colors = array();
            foreach($taken_colors as $color){
                array_push($colors, $color->plyr_color);
            }
            echo json_encode($colors);

        }

    }
    
?>