/***************************************************
 *Attack logic. Controls dice rolls, army movements,
 *etc. Responds to attack related events on map.
 ***************************************************/

/*****************************************************
 *When attack button is clicked, a table is written to
 *the screen that will hold the attacking country, and
 *a dropdown of all attackable countries.
 *****************************************************/
$('#attk_btn').ready(function(){
    make_clicks();
});
 


/*******************************************************
 *Controls roll mechanics. Sets the amount of dice
 *available to attacker and defender. Controls army
 *reductions from attacks, and army movements on victory.
 ********************************************************/
function roll_attk(){
    
    var attk_armies = $("#dice").val();
    var def_armies = 0; 
    var attk_id = $("#attack").text();
    var attk_terr = GameSpace.graph.get_node(attk_id);
    var def_id = $("#attackable option:selected").val();
    var def_terr = GameSpace.graph.get_node(def_id);

    if(def_terr.data.armies > 1)
        def_armies = 2;
    else
        def_armies = 1;
        
    roll_process(attk_armies, def_armies, attk_terr, def_terr);
   
    if(def_terr.data.armies === 0)
        victory_process(attk_terr, def_terr, attk_armies);
    
    else
        battle_process(attk_terr, def_terr); 
}

/**********************************************************
 *Processes attacker and defender rolls, and displays results.
 *Long procedural mess... c'est la vie ...
 *@param attk_armies
 *@param def_armies
 *@param attk_terr
 *@param def_terr
 ***********************************************************/
function roll_process(attk_armies, def_armies, attk_terr, def_terr){

    var attk_result = "";
    var def_result = "";

    var attk_roll = [];
    var def_roll = [];

    for(i=0; i < attk_armies; i++){
        attk_roll[i] = Math.floor((Math.random()*6)+1);
        attk_result += attk_roll[i] + ", ";
    }
    
    for(i=0; i < def_armies; i++){
        def_roll[i] = Math.floor((Math.random()*6)+1);
        def_result += def_roll[i] + ", ";
    }
    
    if(attk_armies > 1)
        attk_roll.sort(function(a,b){return b-a});
    
    if(def_armies > 1)
        def_roll.sort(function(a,b){return b-a});
    
    
    if(attk_roll[0] > def_roll[0]){
        if (def_terr.data.armies > 0) 
            def_terr.data.armies--;  
    }
    else{
        if(attk_terr.data.armies > 1){
            
            attk_terr.data.armies--;

            if(attk_terr.data.armies <= 3){

                var dice_options = '';

                if(attk_terr.data.armies == 3)
                    attk_armies = 2;
                if(attk_terr.data.armies == 2)
                    attk_armies = 1;

                
                //make into a function
                diceMaker(attk_armies);
            }
        }
        
        if(attk_terr.data.armies === 1)
            $("#roll").attr("disabled", true);     
    } 
    if(attk_armies > 1 && def_armies > 1){  
        if(attk_roll[1] > def_roll[1]){
            
            if (def_terr.data.armies > 0) 
                def_terr.data.armies--;
                
            if(def_terr.data.armies === 0){
                $("#roll").attr("disabled", true);
            }
        }
        else{
            if(attk_terr.data.armies > 1) 
                attk_terr.data.armies--;
            
            if(attk_terr.data.armies === 1)
                $("#roll").attr("disabled", true);     
        }
    }

    $("#result").val(attk_result + " /// " + def_result);

    $.post(BASE+'/attack?game_id='+game_id,
           {game_table: game_table,
            attk_owner: attk_terr.data.owner_id,
            def_owner: def_terr.data.owner_id,
            attk_armies: attk_terr.data.armies,
            def_armies: def_terr.data.armies,
            attk_id: attk_terr.data.pk_id,
            def_id: def_terr.data.pk_id},
            function(result){
                console.log(result);

            }
    )
}

/************************************************************
* Determines the minimum number of armies that must be moved
* into newly acquired territory. Prompts user to move armies.
* Updates army counts, and owner IDs over attacker and defender
* territories. Checks attacker's 'card status' to determine 
* whether s/he should receive a card for the victory. If this
* is the first victory in a turn, a card is awarded.
* @param: attk_terr - attacker territory node in GameSpace.graph
* @param: def_terr - defender territory node in GameSpace.graph
* @param: attk_armies - number of armies used in attack (1-3)
*************************************************************/
function victory_process(attk_terr, def_terr, attk_armies){

    $("#roll").attr("disabled", true);
  
    var armies = "";
    
   
    for(i=parseInt(attk_armies); i < attk_terr.data.armies; i++)
        armies += '<option id="'+i+'">'+i+'</option>';

    $('#takeover_select').html('<select id="army_amount">'+armies+'</select>');

    takeOver(attk_terr, def_terr);
}


function takeOver(attkTerr, defTerr){

    $('#take_over').modal({keyboard:false});
    
    $('#occupy').click(function(){
        //null check b/c attkTerr and defTerr must be set to null at
        //end of anonymous function to prevent memory leak
        if(attkTerr !== null && defTerr !== null){

            alert('attk:'+attkTerr.id+' def:'+defTerr.id);
            var def_id_holder = defTerr.data.owner_id;
            var mov_armies = parseInt($("#takeover_select").find(":selected").text());
            
            attkTerr.data.armies -= mov_armies;
            defTerr.data.armies = mov_armies;
            defTerr.data.owner_id = attkTerr.data.owner_id;
            defTerr.data.color = attkTerr.data.color;

            $.post(BASE+'/take_over?game_id='+game_id,
                {game_table: game_table,
                attk_id: attkTerr.data.pk_id,
                def_id: defTerr.data.pk_id,
                attacker_id: attkTerr.data.owner_id,
                defender_id: def_id_holder,
                attk_armies: attkTerr.data.armies,
                def_armies: defTerr.data.armies},
                
                function(result){
                    var terr = JSON.parse(result); 
                    if(terr.attkTerr === 42){
                        alert('You are victorious!');
                        location.reload();
                    }
                }
            );

            $.get(BASE+'/card_status?game_id='+game_id,
                {owner_id: attkTerr.data.owner_id,
                game_id: game_id},
                function(result){
                        
                    var res = JSON.parse(result); 
                    if(res.got_card == 0){
                        console.log(res.got_card);
                        makeCard(res.owner_id, game_id );
                    }

                    $('#take_over').modal('hide');
            
                }
            );
            
            battle_process(attkTerr, defTerr); 
            //set to null to prevent memory leak (maybe a little hackish)
            attkTerr = null;
            defTerr = null;
        }
    });

   
}

/****************************************************
* Updates displayed count and color with 
* each attack.
* @param attk_terr - attacker territory node in GameSpace.graph
* @param def_terr - defender territory node in GameSpace.graph
*****************************************************/
function battle_process(attk_terr, def_terr){
    if(attk_terr.data.owner_id === user_id){
        $("div[name="+attk_terr.id+"]").html('<h3 style="color:'+attk_terr.data.color+';">'+attk_terr.data.armies+'</h3>');
        $("div[name="+def_terr.id+"]").html('<h3 style="color:'+def_terr.data.color+';">'+def_terr.data.armies+'</h3>');

    
        make_clicks();
    }
}


/****************************************************
* Generates a random number between 1-3 for army type.
* 1 = infantry, 2 = cavalry, 3 = cannon. Also generates
* a random number between 0-41 for territory ID. Then
* posts values to controller method.
* @param: ownerID owner facebook id number.
*****************************************************/
function makeCard(ownerID, gameID){

    var armyNum = Math.floor((Math.random()*3)+1);
    var terrID = Math.floor((Math.random()*41)); //check against territories in current hand (get currcards)
    var armyType = 0;
    var terrName = $("#terr"+terrID).attr('name');
    
    if(armyNum == 1)
        armyType = 'Infantry';
    if(armyNum == 2)
        armyType = 'Cavalry';
    if(armyNum == 3)
        armyType = 'Cannon';

    //post card shit
    $.post(BASE+'/make_card?game_id='+game_id,
           {game_id: game_id,
            card_table: card_table, //need to refactor so this isn't needed
            owner_id: ownerID,
            army_type: armyType,
            terr_name: terrName},
            function(result){
                console.log(result);
            }
    );
}

/*******************************************************************
* Checks if cards are valid for turn in to receive bonus armies.
********************************************************************/
function checkCards(cards){

    var form_data = $("#cards_check").serializeArray();
    
    if(form_data.length === 3){
        $.post(BASE+'/card_turn_in?game_id='+game_id,
               {owner_id: user_id,
                data: form_data},
               function(result){
                    console.log(result);
               }
        );
    }
    return false;
}

/********************************************************************
 *Makes territories clickable. If territory has more than one army,
 *and is owned by attacker, attack options are written to document.
 *@param: continent - class identifier for territory divs in html view
 *********************************************************************/
function code_click(continent){
     
       $(continent).each(function(){
            
            var node = GameSpace.graph.get_node($(this).attr('name'));
          
            if(node.data.owner_id === user_id){   
               
                $(this).click(function(){
        
                    border_list = [];
                    $("#attack").text(node.id);
            
                    node.edges.forEach(function(border){
                        var border_node = GameSpace.graph.get_node(border); 
                        
                        if(border_node.data.owner_id !== node.data.owner_id) 
                            border_list.push(border);
                                
                    });
                    
                    if(node.data.armies > 1) {
                      
                        var attk_count;

                        if(node.data.armies > 3)
                            attk_count = 3;
                        else if(node.data.armies === 3)
                            attk_count = 2;
                        else
                            attk_count = 1;
                        
                        //make into a function
                        diceMaker(attk_count);

                        var terr_options = "";
                        var def_count = 0;
                        
                        for(i=0; i < border_list.length; i++) 
                            terr_options+="<option id='"+border_list[i]+"'>"+border_list[i]+"</option>";
                                
                        var country_select = "<select id='attackable'>"+terr_options+"</select>";  
                        $("#defend").html(country_select);
                    }
                    else{
                        $("#attack").html("<p>PLEASE SELECT A TERRITORY WITH MORE THAN 1 ARMY.</p>");
                        $("#select").html("");
                    }
                    
                }); 
            
            }
                
        });
        
}

/************************************
* Makes the nodes in each continent
* clickable.
************************************/
function make_clicks(){

    code_click(".north_america");
    code_click(".south_america");
    code_click(".europe");
    code_click(".africa");
    code_click(".asia");
    code_click(".australia");
}


/***********************************
* Dice make
************************************/
function diceMaker(attk_count){

    var dice_options = '';
    for(i=1; i <= attk_count; i++){
        dice_options += '<option id="'+i+'">'+i+'</option>';
                           
    }
                        
    $("#select").html('<select id="dice">'+dice_options+'</select>\
        <input id="roll" type="submit" value="roll" onclick="roll_attk()">\
        <input id="result" type="text" width="100px" value="roll_result">');
}