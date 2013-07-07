/***********************************
* Sets 'place army' clicks
************************************/
$("#place_btn").ready(function(){

    create_clicks(); 
});


/*******************************************
* Posts placed armies
*********************************************/ 
function placeArmies(placeName){
    
    var placeTerr = graph.get_node(placeName);
    var placeID = placeTerr.data.pk_id;
    
    //needs to get terr amount from server
    var amount = parseInt($("#place_amount").find(":selected").text());
   
    var newAmount = placeTerr.data.armies + amount;

    $("div[name="+placeTerr.id+"]").html('<h3 style="color:'+placeTerr.data.color+';">'+newAmount+'</h3>');
               
    $.post(BASE+'/place?game_id='+game_id,
             {armies: amount,
              uid: user_id,
              game_id: game_id,
              terr_num: placeTerr.data.pk_id-1,
              game_table: game_table},
              function(result){
                $("#place_armies").html("<p>"+result+" ARMIES REMANING</p>");

                setAmount(placeTerr, result);
                init_armies = result;
                if(result == 0)
                    location.reload();
              }
    );
        

}   

/*********************************************
* Add placed armies to terr army count and
* updates place army select drop.
**********************************************/
function setAmount(territoryNode, armyAmount){

    var armies = "";
                   
    for(i=1; i <= armyAmount; i++)
        armies += '<option id="'+i+'">'+i+'</option>';
       
    var newAmount = territoryNode.data.armies + armies;
    $("#place").html('<select id="place_amount">'+armies+'</select><input id="mov_armies" type="button" class="btn btn-inverse" value="place" onclick="placeArmies(\''+territoryNode.id+'\');"> in '+territoryNode.id);                
}

/*******************************
* Makes terrs clickable for
* army placement
********************************/
function place_click(continent){
    
   $(continent).each(function(){
           
        var node = graph.get_node($(this).attr('name'));
      
        if(node.data.owner_id === user_id && init_armies > 0){   
           
            $(this).click(function(){
                setAmount(node, init_armies);
            }); 
        
        }
            
    });
        
}

/****************************
* Makes territories unclickable
* with regard to placement.
*******************************/
function unClick(continent){
    $(continent).each(function(){
               
        var node = graph.get_node($(this).attr('name'));
      
        if(node.data.owner_id === user_id){   
             $(this).attr("disabled", true);
        }
    });

}

/**********************
* see above ;)
**********************/
function unDoClicks(){

    unClick(".north_america");
    unClick(".south_america");
    unClick(".europe");
    unClick(".africa");
    unClick(".asia");
    unClick(".australia");
}

/************************************
* Makes the nodes in each continent
* clickable.
************************************/
function create_clicks(){

    place_click(".north_america");
    place_click(".south_america");
    place_click(".europe");
    place_click(".africa");
    place_click(".asia");
    place_click(".australia");
}