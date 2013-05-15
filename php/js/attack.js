/***************************************************
 *Attack logic. Controls dice rolls, army movements,
 *etc.
 ***************************************************/

/*****************************************************
 *When attack button is clicked, a table is written to
 *the screen that will hold the attacking country, and
 *a dropdown of all attackable countries.
 *****************************************************/
$("#attk_btn").ready(function(){
   
    $("#attk_btn").click(function(){
        
        $('#attk_mode').append('<table><tr><td>\
                             <div id="select"></div>\
                           </td>\
                        </tr>\
                        <tr>\
                        <td>\
                          <p id="attack">ATTACKING COUNTRY</p> --->\
                        </td>\
                        </tr>\
                        <tr><td id="defend"></td></tr>');
        
         //test clickies
        code_click(".north_america");
        code_click(".south_america");
        code_click(".europe");
        code_click(".africa");
        code_click(".asia");
        code_click(".australia");
        
        $('#attk_btn').attr("disabled", true);	
    });
});

/*******************************************************
 *Controls roll mechanics. Sets the amount of dice
 *available to attacker and defender. Controls army
 *reductions from attacks, and army movements on victory.
 ********************************************************/
function roll_attk(){
    
    var attk_armies = $("#dice").val();
    var def_armies = 0; 
    var attk_roll = [];
    var def_roll = [];
    var attk_result = "";
    var def_result = "";
    

    var attk_id = $("#attack").text();
    var attk_terr = graph.get_node(attk_id);
    
    var def_id = $("#attackable option:selected").val();
    var def_terr = graph.get_node(def_id);

    if(def_terr.data.armies > 1)
        def_armies = 2;
    else
        def_armies = 1;
        
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
        if(attk_terr.data.armies > 1) 
            attk_terr.data.armies--;
        
        if(attk_terr.data.armies === 1)
            $("#roll").attr("disabled", true);     
    } 
    if(attk_armies > 1 && def_armies > 1){  
        if(attk_roll[1] > def_roll[1]){
            
            if (def_terr.data.armies > 0) 
                def_terr.data.armies--;
                
            if(def_terr.data.armies === 0) 
                $("#roll").attr("disabled", true);
                //probably set some card flag here for particular instance of player object
        }
        else{
            if(attk_terr.data.armies > 1) 
                attk_terr.data.armies--;
            
            if(attk_terr.data.armies === 1)
                $("#roll").attr("disabled", true);     
        }
    }
    
    if(def_terr.data.armies === 0){
        
        $("#roll").attr("disabled", true);
        def_terr.data.owner = attk_terr.data.owner;
        var mov_armies = prompt("How many armies would you like to move?:");//maybe a popup plugin instead.
        
        while (1){
            
            if (mov_armies > attk_terr.data.armies - 1) {
                mov_armies = prompt("You cannot move that many armies!");//maybe a popup plugin instead.
                if(mov_armies <= attk_terr.data.armies - 1)
                    break;
            }
            else if(attk_armies === "3" && mov_armies < 3){
                mov_armies = prompt("You must move at least 3 armies!");//maybe a popup plugin instead.
                if (mov_armies >= 3) 
                    break;
                
            }
            else if(attk_armies === "2" && mov_armies < 2){
                mov_armies = prompt("You must move at least 2 armies!");//maybe a popup plugin instead.
                if (mov_armies >= 2) 
                    break;
            }
            else if(attk_armies === "1" && mov_armies < 1){
                mov_armies = prompt("You must move at least 1 armies!");//maybe a popup plugin instead.
                if (mov_armies >= 1) 
                    break;
            }   
            else 
                break;
        }
        
        attk_terr.data.armies -= mov_armies;
        def_terr.data.armies = mov_armies;
        
    }
    
    //add country take over options.
    //temporary stuff:
    if(attk_terr.data.owner === "Nick")
        $("div[name="+attk_terr.id+"]").html('<p style="color:pink;">'+attk_terr.data.armies+'</p>');
    if(def_terr.data.owner === "Nick") 
        $("div[name="+def_terr.id+"]").html('<p style="color:pink;">'+def_terr.data.armies+'</p>');
    
    if(attk_terr.data.owner === "Frank")
        $("div[name="+attk_terr.id+"]").html('<p style="color:blue;">'+attk_terr.data.armies+'</p>');
    if(def_terr.data.owner === "Frank") 
        $("div[name="+def_terr.id+"]").html('<p style="color:blue;">'+def_terr.data.armies+'</p>');
        
    $("#result").val(attk_result + " /// " + def_result);
    
}

/*************************************************************
 *Makes territories clickable. If territory has more than one army,
 *and is owned by attacker, attack options are written to document.
 *************************************************************/
function code_click(continent){
        
       $(continent).each(function(){
            
            var node = graph.get_node($(this).attr('name'));
        
                
                $(this).click(function(){
            
                    border_list = [];
                    $("#attack").text(node.id);
                    
                    node.edges.forEach(function(border){
                        var border_node = graph.get_node(border); 
                        
                        if(border_node.data.owner !== node.data.owner) 
                            border_list.push(border);
                                
                    });
                    
                    if(node.data.armies > 1) {
                      
                    
                        var dice_options = "";
                        for(i=1; i < 4; i++){
                            dice_options += '<option id="'+i+'">'+i+'</option>';
                            if(node.data.armies === 3 && i === 2)
                                break;
                            if(node.data.armies === 2 && i === 1)
                                break;
                        }
                        
                        $("#select").html('<select id="dice">'+dice_options+'</select>\
                                            <input id="roll" type="submit" value="roll" onclick="roll_attk()">\
                                            <input id="result" type="text" width="100px" value="roll_result">');
                        
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
            

                
        });
        
}