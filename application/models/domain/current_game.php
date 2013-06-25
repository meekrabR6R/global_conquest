<?php

class CurrentGame{

	//fields
	private $game;
	private $game_maker;
	private $game_table;
	private $game_state;
	private $players;
	private $player_count;
	private $player_up;
	private $player_list;
	private $player_colors;
	private $card_tabe;

	//constructor
	public function __construct($game_id){

		$this->game = Games::where('game_id', '=', $game_id)->first();
		$this->game_maker = $this->game->maker_id;
		$this->game_table = 'game'.$game_id;
		$this->game_state = GameTable::getGameState($this->game_table);
		$this->card_table = 'cards'.$game_id;

		$this->players = Plyrgames::where('game_id','=', $game_id)->get();
		$this->player_count = Plyrgames::where('game_id','=', $game_id)->count();
		$this->player_list = Plyrgames::getFirstNames($game_id);//maybe brin this method into this class?
		$this->player_colors = Plyrgames::getPlyrColor($this->players, $game_id);

		if($this->game->turns_set == 0 && $this->player_count == $this->game->plyrs)
           $this->makeTurns($this->game, $game_id, $this->players, $this->player_count);
        
        elseif($this->player_count == $this->game->plyrs)
        	$this->player_up = Plyrgames::where('game_id','=', $game_id)->where('trn_active','=',1)->first();
	
	}

	/***************************************
	* Gets init armies for 'up player'
	*****************************************/
	public function getInitArmies($user_id){
     
        foreach($this->players as $player){
            
            if($user_id == $player->plyr_id)
                return $player->init_armies;  
        }
    }

    /*************************************
	* Checks membership status of user for
	* current game.
	**************************************/
    public function isMember($user_id){

        foreach($this->players as $player){
            if($user_id == $player->plyr_id)
                return true;
        }

        return false;

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
    * Checks if all players' initial armies are 
    * placed
    *********************************************/
     public function armiesPlaced(){

        $set_flag = 0;
        foreach($this->players as $player){
            if($player->init_armies > 0)
                $set_flag = 1;
        }

        if($set_flag == 0)
            return true;
        else
            return false;
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

	public function getPlayerList(){

		return $this->player_list;
	}

	public function getPlayerColors(){

		return $this->player_colors;
	}

	public function getUpPlayer(){

		return $this->player_up;
	}
}

?>