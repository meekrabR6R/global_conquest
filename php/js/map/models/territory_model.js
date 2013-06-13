/*************************************
* Territory prototype (inherits this)
**************************************/

function Territory(){
	Graph.call(this);
}

Territory.prototype = new Graph();

//Main attack method.
Territory.prototype.attack = function(attkID, defID, attkArmies){

	//var attkArmies = $("#dice").val();
    var defArmies = 0; 
    //var attkID = $("#attack").text();
    var attkTerr = this.get_node(attkID);
    //var defID = $("#attackable option:selected").val();
    var defTerr = this.get_node(defID);

    if(defTerr.data.armies > 1)
        defArmies = 2;
    else
        defArmies = 1;
        
    return Territory.rollProcess(attkArmies, defArmies, attkTerr, defTerr);
    
    //if(defTerr.data.armies === 0)
       // Territory.victoryProcess(attkTerr, defTerr, attkArmies);
        
    //Territory.battleProcess(attkTerr, defTerr); 
}

//static method to process attack/defense rolls
Territory.rollProcess = function (attkArmies, defArmies, attkTerr, defTerr){

    var attkResult = "";
    var defResult = "";

    var attkRoll = [];
    var defRoll = [];

    for(i=0; i < attkArmies; i++){
        attkRoll[i] = Math.floor((Math.random()*6)+1);
        attkResult += attkRoll[i] + ", ";
    }
    
    for(i=0; i < defArmies; i++){
        defRoll[i] = Math.floor((Math.random()*6)+1);
        defResult += defRoll[i] + ", ";
    }
    
    if(attkArmies > 1)
        attkRoll.sort(function(a,b){return b-a});
    
    if(defArmies > 1)
        defRoll.sort(function(a,b){return b-a});
    
    
    if(attkRoll[0] > defRoll[0]){
        if (defTerr.data.armies > 0) 
            defTerr.data.armies--;  
    }
    else{
        if(attkTerr.data.armies > 1) 
            attkTerr.data.armies--;
        
        if(attkTerr.data.armies === 1)
            $("#roll").attr("disabled", true);     
    } 
    if(attkArmies > 1 && defArmies > 1){  
        if(attkRoll[1] > defRoll[1]){
            
            if (defTerr.data.armies > 0) 
                defTerr.data.armies--;
                
            if(defTerr.data.armies === 0)
                $("#roll").attr("disabled", true);

        }
        else{
            if(attkTerr.data.armies > 1) 
                attkTerr.data.armies--;
            
            if(attkTerr.data.armies === 1)
                $("#roll").attr("disabled", true);     
        }
    }

   // $("#result").val(attkResult + " /// " + defResult);

   // $.post(BASE+'/attack',
     //      {game_table: game_table,
       //     attk_armies: attkTerr.data.armies,
         //   def_armies: defTerr.data.armies,
          //  attk_id: attkTerr.data.pk_id,
          //  def_id: defTerr.data.pk_id},
          //  function(result){
           //     console.log(result);
           // }
    //)
	return {'attkResult': attkResult, 'defResult': defResult, 'attkArmies': attkArmies,
			'defArmies': defArmies, 'attkPK': attkTerr.data.pk_id, 'defPK': defTerr.data.pk_id};
}
