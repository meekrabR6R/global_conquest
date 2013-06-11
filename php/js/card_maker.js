
/****************************************************
* Generates a random number between 1-3 for army type.
* 1 = infantry, 2 = cavalry, 3 = cannon. Also generates
* a random number between 0-41 for territory ID. Then
* posts values to controller method.
* @param: ownerID owner facebook id number.
*****************************************************/
function makeCard(ownerID){

	armyType = Math.floor((Math.random()*3)+1);
	terrID = Math.floor((Math.random()*41)); //check against territories in current hand (get currcards)

	//post card shit
	$.post(BASE+'/make_card',
		   {owner_id: ownerID,
		    army_type: armyType,
			terr_id: terrID},
			function(result){
				console.log(result);
			}
	);
}