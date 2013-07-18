<?php

class CurrentGame{

	//fields
	private $game;
    private $game_id;
	private $game_maker;
	private $game_table;
	private $game_state;
	private $players;
	private $player_count;
	private $player_up;
	private $card_tabe;
	//constructor
	public function __construct($game_id){

        $this->game_id = $game_id;
		$this->game = Games::where('game_id', '=', $game_id)->first();
		$this->game_maker = $this->game->maker_id;
		$this->game_table = 'game'.$game_id;
		$this->game_state = GameTable::getGameState($this->game_table);
		$this->card_table = 'cards'.$game_id;
    
        //creates player list
        $plyr_records = Plyrgames::where('game_id','=', $game_id)->get();
        $this->players = array();
        
        foreach($plyr_records as $plyr_record)
            array_push($this->players, new Player($plyr_record->plyr_id, $game_id));
        
        $this->player_count = sizeof($this->players);

        //sets turn order
		if($this->game->turns_set == 0 && $this->player_count == $this->game->plyrs)
           $this->makeTurns($this->game, $game_id, $plyr_records, $this->player_count);
        
        //processes 'up player's' army count (export to own method)
        elseif($this->player_count == $this->game->plyrs){
        	$this->player_up = Plyrgames::where('game_id','=', $game_id)->where('trn_active','=',true)->first();
            $this->makeTurnArmies();
        }
	
	}

    /***************************************
    * Get status of starting army placements.
    ****************************************/
    public function startArmiesPlaced(){

        return  $this->game->init_placed+0;
    }


	/***************************************
	* Gets init armies for 'up player'
	*****************************************/
	public function getInitArmies($user_id){
     
        foreach($this->players as $player){
            
            if($user_id == $player->getPlyrID())
                return $player->getInitArmies();  
        }
    }

    /*************************************
	* Checks membership status of user for
	* current game.
	**************************************/
    public function isMember($user_id){

        foreach($this->players as $player){
            if($user_id == $player->getPlyrID())
                return true;
        }

        return false;

    }

    /*************************************************************
    * Transfers active turn status to next player in turn queue.
    **************************************************************/
    public function nextTurn($user_id){

        $curr_plyr = Plyrgames::where('plyr_id', '=', $user_id)->where('game_id', '=', $this->game_id)->first();
        $curr_plyr->turn_armies_set = false;
        $curr_plyr->save();

        $curr_plyr->trn_active = false;
        $curr_plyr->save();

        $curr_plyr->got_card = false;
        $curr_plyr->save();

        $curr_turn = $curr_plyr->turn;
        $tot_plyrs = Games::where('game_id', '=',$this->game_id)->first()->plyrs;

        if($curr_turn < $tot_plyrs)
            $next_turn = $curr_turn + 1;
        else
            $next_turn = 1;
 
        //sets next player in queue to 'active'
        $next_plyr = Plyrgames::where('game_id', '=', $this->game_id)->where('turn', '=', $next_turn)->first();
        $next_plyr->trn_active = 0;
        $next_plyr->save();
        
        return $curr_plyr;
    }

    /*****************************************
    * Move armies, end turn, and pass turn to
    * next player.
    ******************************************/
    public function moveArmies($user_id, $from_id, $to_id, $from_amount, $to_amount){

        GameTable::moveArmies($this->game_table, $from_id, $to_id, $from_amount, $to_amount);
        $this->nextTurn($user_id);
    }
    
    /*****************************************
    * Updates attacker/defender army counts 
    * and checks new counts of each.
    ******************************************/
    public function attack($attk_owner, $def_owner, $attk_armies, $attk_id, $def_armies, $def_id){

        GameTable::attack($this->game_table, $attk_armies, $attk_id, $def_armies, $def_id);

     
    }

    /****************************************
    * Update terrs for attacker/defender
    *****************************************/
    public function takeOver($attk_owner, $def_owner, $attk_id, $def_id, $attk_armies, $def_armies){

        GameTable::takeOver($this->game_table, $attk_armies, $attk_id, $attk_owner, $def_armies, $def_id);

        $territory_count = array();
        foreach($this->players as $player){

            if($player->getPlyrID() == $attk_owner)
                $territory_count['attk_terr'] = $player->getTerrCount();
            
            if($player->getPlyrID() == $def_owner)
                $territory_count['def_terr'] = $player->getTerrCount();
        }

        Plyrgames::checkTerrCounts($this->game_id, $attk_owner, $def_owner, $territory_count);
        
        return $territory_count;
    }

    /*****************************************
    * Get 'up player's' card hand
    ******************************************/
    public function getHand($user_id){

    	$card_state = CardTable::getCardTableState($this->card_table);
        $cards = CardTable::getNumberOfCards($user_id, $this->card_table); //keep this here for 'if 5' 
        $player_cards = array();
       
        foreach($card_state as $card){
           if($card->owner_id == $user_id)
                array_push($player_cards, array('army_type' => $card->army_type, 'terr_name' => $card->terr_name));   
        }

        return $player_cards;
    }

    /***************************************************
    * Checks if turn in
    ***************************************************/
    public function isTurnIn($cards){

        $check_123 = array('Cannon', 'Cavalry', 'Infantry');
        $check_infantry = array('Infantry', 'Infantry', 'Infantry');
        $check_cavalry = array('Cavalry', 'Cavalry', 'Cavalry');
        $check_cannon = array('Cannon', 'Cannon', 'Cannon');

        $types = array();
        foreach($cards as $card)
            array_push($types, $card['value']);
        
        sort($types);

        if($check_123 === $types || $check_infantry === $types ||
            $check_cavalry === $types || $check_cannon === $types)
            return true;
        else
            return false;
        
    }

    /********************************************************************
    * Awards card
    *********************************************************************/
    public function awardCard($owner_id, $army_type, $terr_name){
        
        CardTable::insert_card($this->card_table, $owner_id, $army_type, $terr_name);
        $player = Plyrgames::where('game_id', '=', $this->game_id)->where('plyr_id','=', $owner_id)->first();
        $player->got_card = 1;
        $player->save();
    }

    /********************************************************************
    * Turn in cards
    *********************************************************************/
    public function turnInCards($owner_id, $cards){

    	 $turn_ins = $this->game->turn_ins;
    	 $this->game->turn_ins += 1;
    	 $this->game->save();
    	 
    	 $bonus_armies = $this->getBonusArmies($turn_ins);

    	 //maybe this bit needs to be elsewhere?
    	 $player = Plyrgames::where('plyr_id', '=', $owner_id)->where('game_id', '=', $this->game_id)->first();
    	 $player->init_armies += $bonus_armies;
    	 $player->save();
    	 
    	 CardTable::deleteCards($owner_id, $cards, $this->card_table);

    	 return $bonus_armies;

    }

    /******************************************************************
    * Check if game has winner.
    *******************************************************************/
    public function getWinner(){

        foreach($this->players as $player){

            if($player->isWinner())
                return $player;
        }

        return false;
    }

    /********************************************
    * Gets bonus armies from turn in.
    *********************************************/
    private function getBonusArmies($turn_ins){

        if($turn_ins < 5){
            if($turn_ins == 0)
                return 4;
            else
                return $this->getBonusArmies($turn_ins - 1) + 2;
        }
        else{
            if($turn_ins == 5)
                return 15;
            else
                return $this->getBonusArmies($turn_ins - 1) + 5;
        }
    }

    /***********************************
    * Sets turn armies.
    ***********************************/
    private function makeTurnArmies(){

        if($this->player_up->turn_armies_set == false && $this->player_up->init_armies === 0){
            $turn_armies = Plyrgames::getTurnArmies($this->game_id, $this->player_up->plyr_id);
            $turn_armies += $this->continentBonuses();

            $this->player_up->init_armies = $turn_armies;
            $this->player_up->save();

            $this->player_up->turn_armies_set = true;
            $this->player_up->save();
        }
    }
    /**********************************
    * Gets continent bonuses for up
    * player
    ***********************************/
    private function continentBonuses(){

        $northAmeriCount = 0;
        $southAmeriCount = 0;
        $euroCount = 0;
        $afriCount = 0;
        $asiaCount = 0;
        $aussieCount = 0;
        
        $continentBonuses = 0;

        foreach($this->game_state as $territory){

            if($territory->owner_id == $this->player_up->plyr_id){
                    $continent = $territory->continent; 
                    
                    if($continent == 'north_america')
                        $northAmeriCount++;
                    if($continent == 'south_america')
                        $southAmeriCount++;
                    if($continent == 'europe')
                        $euroCount++;
                    if($continent == 'africa')
                        $afriCount++;
                    if($continent == 'asia')
                        $asiaCount++;
                    if($continent == 'australia')
                        $aussieCount++;
            }
        }

        if($northAmeriCount == 9)
            $continentBonuses += 5;
        if($southAmeriCount == 4)
            $continentBonuses += 2;
        if($euroCount == 7)
            $continentBonuses += 5;
        if($afriCount == 6)
            $continentBonuses += 3;
        if($asiaCount == 12)
            $continentBonuses += 7;
        if($aussieCount == 4)
            $continentBonuses += 2;

        return $continentBonuses;

    }

	/********************************************************************
	* Sets turn order.
	*********************************************************************/
	private function makeTurns($game, $game_id, $plyr_data, $plyr_count){

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

        //maybe export back to Plyrgames
        $player_one = Plyrgames::where('game_id','=', $game_id)->where('turn','=',1)->first();
        $player_one->trn_active = 1;
        $player_one->save();
        
    }

    /********************************************
    * Places armies and returns new init army
    * count.
    *********************************************/
    public function placeArmies($plyr_id, $armies, $terr_num){

        GameTable::updateArmies($this->game_table, $armies, $terr_num, $this->game_id, $plyr_id);
        $new_initarmies = Plyrgames::where('game_id', '=', $this->game_id)->where('plyr_id', '=', $plyr_id)->first()->init_armies;
        return $new_initarmies;
    }

    /********************************************
    * Checks if all players' initial armies are 
    * placed.. pretty sure this is being used 
    * incorrectly (at least in the client)
    *********************************************/
     public function armiesPlaced(){

        $set_flag = 0;
        foreach($this->players as $player){
            if($player->getInitArmies() > 0)
                $set_flag = 1;
        }

        if($set_flag == 0){

            if($this->startArmiesPlaced() == false){
                $this->game->init_placed = true;
                $this->game->save();
            }
            return true;
        }
        else
            return false;
    }

    private function setTurnArmies($plyr_id){

        Plyrgames::updateTurnArmies($this->game_id, $plyr_id);
    }

    /********************************************************************
    * Saves state of attacker/defender territories in the event that the
    * attacker has not yet taken over the defeated defender's territory.
    **********************************************************************/
    public function saveTakeOverState($attk_terr, $def_terr, $attk_armies){
        
        $this->player_up->attk_terr = $attk_terr;
        $this->player_up->save();

        $this->player_up->def_terr = $def_terr;
        $this->player_up->save();

        $this->player_up->attk_armies = $attk_armies;
        $this->player_up->save();

        $this->player_up->beat_terr = 1;
        $this->player_up->save();

    }

    /**************************************
    * Unsaves takeover state
    ***************************************/
    public function unSaveTakeOverState(){

        $this->player_up->beat_terr = false;
        $this->player_up->save();
    }

	/**********************************
	* Various getters (ugly, I know)
	**********************************/
	public function getGameMaker(){

		return $this->game_maker;
	}

	public function getTableName(){

		return $this->game_table;
	}

	public function getTitle(){

		return $this->game->title;
	}

	public function getPlayers(){

		return $this->players;
	}

	public function getPlayerCount(){

		return $this->player_count;
	}

	public function getGameState(){

		return $this->game_state;
	}

	public function getPlayerLimit(){

		return $this->game->plyrs;
	}

    public function getUpPlayer(){

        if(isset($this->player_up))
            return Players::where('plyr_id', '=', $this->player_up->plyr_id)->first();
    }

    public function getTempTakeOver(){
        if(isset($this->player_up)){
            $take_over = array(
                'beat_terr' => $this->player_up->beat_terr,
                'attk_terr' => $this->player_up->attk_terr,
                'def_terr' => $this->player_up->def_terr,
                'attk_armies' => $this->player_up->attk_armies
            );
            return $take_over;
        }
    }
    public function getPlayerNames(){

        $player_names = array();
        foreach($this->players as $player){
            $name = $player->getName();
            array_push($player_names, $name['first_name']);
        }

        return $player_names;
    }

	public function getPlayerColors(){

		$player_colors = array();
        foreach($this->players as $player)
            array_push($player_colors, array('plyr_id' => $player->getPlyrID(), 'plyr_color' => $player->getColor()));

        return $player_colors;
	}

}

?>