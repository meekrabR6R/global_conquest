var northAmeriCount = 0;
var southAmeriCount = 0;
var euroCount = 0;
var afriCount = 0;
var asiaCount = 0;
var aussieCount = 0;
var continentBonuses = 0;

$(document).ready(function(){

	if(typeof init_armies !== "undefined"){
		if(init_armies > 0 && turnArmiesSet == false){
		    game_state.forEach(function(territory){

		   		if(territory.owner_id === user_id){
		   			var continent = $('#'+territory.terr).attr('class');
		   			
		   			if(continent === 'north_america')
		   				northAmeriCount++;
		   			if(continent === 'south_america')
		   				southAmeriCount++;
		   			if(continent === 'europe')
		   				euroCount++;
		   			if(continent === 'africa')
		   				afriCount++;
		   			if(continent === 'asia')
		   				asiaCount++;
		   			if(continent === 'australia')
		   				aussieCount++;
		   		}

		   });

		    if(northAmeriCount === 9)
		   		continentBonuses += 5;
		   	if(southAmeriCount === 4)
		   		continentBonuses += 2;
		   	if(euroCount === 7)
		   		continentBonuses += 5;
		   	if(afriCount === 6)
		   		continentBonuses += 3;
		   	if(asiaCount === 11)
		   		continentBonuses += 7;
		   	if(aussieCount === 4)
		   		continentBonuses += 2;

		   	$.post(BASE+'/continent_bonuses?game_id='+game_id,
		   			{continent_bonuses: continentBonuses,
		   			 turn_armies: true},
		   			function(result){
		   				console.log("result "+result);
		   			}
		   	);

	   }
	}


	
});