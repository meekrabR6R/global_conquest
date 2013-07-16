<?php
class Player{
    
	private $plyr_id;
	private $name;
	private $color;
	private $init_armies;
	private $num_terrs;
	private $card_table;
	private $game_table;
    private $game_id;
	private $cards;
	private $record;

	public function __construct($user_id, $game_id){

        $this->game_id = $game_id;
		$this->plyr_id = $user_id;
		$this->record = Plyrgames::where('game_id', '=', $game_id)
    			 		   		 ->where('plyr_id', '=', $this->plyr_id)->first();

    	$this->card_table = 'cards'.$game_id;
    	$this->game_table = 'game'.$game_id;
		$this->name = $this->setName();
		$this->color = $this->record->plyr_color;
		$this->init_armies = $this->record->init_armies;
		$this->num_terrs = $this->getTerrCount();
		$this->cards = $this->getHand();
		
		
	}

	/*************************************
	* Sets first and last name of player.
	**************************************/
	private function setName(){

		$player = Players::where('plyr_id', '=', $this->plyr_id)->first();
		$name = array('first_name' => $player->first_name, 'last_name' => $player->last_name);
		return $name;

	}

	
    /****************************************
    * Count of owned territories
    *****************************************/
    public function getTerrCount(){

    	$bindings = array('owner_id' => $this->plyr_id);
        $terrs = DB::query('select count(owner_id) as terr_count from '.$this->game_table.' where owner_id = ?', $bindings); 
    	return $terrs[0]->terr_count;
    }


	/*************************************
	* Checks membership status of user for
	* current game.
	**************************************/
    public function isMember(){

        if($this->record)
        	return true;
        
        return false;

    }

    /***************************************
    * Check if player is winner
    ****************************************/
    public function isWinner(){

       if($this->record->winner)
            return true;

        return false;
    }

    /****************************************
    * Updates 'turn_armies_set' status
    *****************************************/
    public function toggleArmiesSetStatus($game_id){

    	$player = Plyrgames::where('plyr_id', '=', $this->plyr_id)->where('game_id', '=', $game_id)->first();
    	$armies_set = $player->turn_armies_set;

    	$bindings = array('turn_armies_set' => false, 'game_id' => $game_id, 'plyr_id' => $this->plyr_id);
    	DB::query('update plyr_games set turn_armies_set = ? where game_id = ? and plyr_id = ?', $bindings);
    	
    	
    }

    /*****************************************
    * Get 'up player's' card hand
    ******************************************/
    private function getHand(){

    	$card_state = CardTable::getCardTableState($this->card_table);
        //$cards = CardTable::getNumberOfCards($user_id, $this->card_table); //keep this here for 'if 5' 
        $player_cards = array();
       
        foreach($card_state as $card){
           if($card->owner_id == $this->plyr_id)
                array_push($player_cards, array('army_type' => $card->army_type, 'terr_name' => $card->terr_name));   
        }

        return $player_cards;
    }

      /***************************************************
    * Checks if turn in
    ***************************************************/
    public function hasTurnIn($hand){

        $check_123 = array('Cannon', 'Cavalry', 'Infantry');
        $check_infantry = array('Infantry', 'Infantry', 'Infantry');
        $check_cavalry = array('Cavalry', 'Cavalry', 'Cavalry');
        $check_cannon = array('Cannon', 'Cannon', 'Cannon');

        $types = array();
        foreach($hand as $card)
            array_push($types, $card['value']);
        
        sort($types);

        if($check_123 === $types || $check_infantry === $types ||
            $check_cavalry === $types || $check_cannon === $types)
            return true;
        else
            return false;
        
    }

    /********************************************************************
    * Turn in cards
    *********************************************************************/
    public function turnInCards($hand){

    	 $turn_ins = $this->game->turn_ins;
    	 $this->game->turn_ins += 1;
    	 $this->game->save();
    	 
    	 $bonus_armies = $this->getBonusArmies($turn_ins);

    	 //maybe this bit needs to be elsewhere?
    	 $player = Plyrgames::where('plyr_id', '=', $owner_id)->first();
    	 $player->init_armies += $bonus_armies;
    	 $player->save();
    	 
    	 CardTable::deleteCards($owner_id, $hand, $this->card_table);

    	 return $bonus_armies;

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

     //getters
    public function getPlyrID(){
    	return $this->plyr_id;
    }

	public function getName(){
		return $this->name;
	}  

	public function getColor(){
		return $this->color;
	}

	public function getInitArmies(){
		return $this->init_armies;
	}

}
?>