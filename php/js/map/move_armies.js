
/***********************************
* Sets 'move army' clicks
************************************/
$("#mov_btn").ready(function(){
    
    $("#mov_btn").click(function(){
        
      	set_clicks();
        
    
          
    });  
});


/*******************************************
* Posts 'from' and 'to' territory ids, as well
* as army amount.
* @param fromID - ID of territory from which
* armies are being moved
*********************************************/ 
function moveArmies(){
    
    var toTerr = graph.get_node($('#movable').find(":selected").text());
    var toID = toTerr.data.pk_id;
    
    var fromName = $.trim($('#select_text').text().split(':')[1]);

    var fromTerr = graph.get_node(fromName);
    var fromID = fromTerr.data.pk_id;
   

    var amount = parseInt($("#army_amount").find(":selected").text());
   
    var fromAmount = fromTerr.data.armies - amount;
    var toAmount = toTerr.data.armies + amount;

    $("div[name="+fromTerr.id+"]").html('<p style="color:'+fromTerr.data.color+';">'+fromAmount+'</p>');
    $("div[name="+toTerr.id+"]").html('<p style="color:'+toTerr.data.color+';">'+toAmount+'</p>');
    
    $('#roll').attr("disabled", true); //change to end turn
           
    $.post(BASE+'/move_armies',
            {game_table: game_table,
             game_id: game_id,
             user_id: user_id,
             from_id: fromID,
             to_id: toID,
             from_amount: fromAmount,
             to_amount: toAmount},
            function(result){
                location.reload();
            }
    );
        

}   

function move_click(continent){
        
       $(continent).each(function(){
            
            var node = graph.get_node($(this).attr('name'));
          
            if(node.data.owner_id === user_id){   
               
                $(this).click(function(){
                    
                    border_list = [];
                    $("#select_text").text('From: ' + node.id);
                    
                    node.edges.forEach(function(border){
                        var border_node = graph.get_node(border); 
                        
                        if(border_node.data.owner_id === node.data.owner_id) 
                            border_list.push(border);
                                
                    });
                    
                    if(node.data.armies > 1) {
                      
                        var armies = "";
                       
                        for(i=1; i < node.data.armies; i++)
                            armies += '<option id="'+i+'">'+i+'</option>';
                           
                        
                        $("#select_from").html('<select id="army_amount">'+armies+'</select>');
                        
                        var mov_options = "";
                                                
                        for(i=0; i < border_list.length; i++) 
                            mov_options+="<option id='"+border_list[i]+"'>"+border_list[i]+"</option>";
       
                        var country_select = "To: <select id='movable'>"+mov_options+"</select>";  
                      
                        $("#select_to").html(country_select + '<input id="mov_armies" type="button" class="btn btn-inverse" value="move" onclick="moveArmies();">');
                       
                    }
                    else{
                        $("#select_from").html('<p>PLEASE SELECT A TERRITORY WITH MORE THAN 1 ARMY.</p>');
                    }
                    
                }); 
            
            }
                
        });
        
}

/************************************
* Makes the nodes in each continent
* clickable.
************************************/
function set_clicks(){

    move_click(".north_america");
    move_click(".south_america");
    move_click(".europe");
    move_click(".africa");
    move_click(".asia");
    move_click(".australia");
}


/**************************************
* Ends turn
***************************************/
$("#end").ready(function(){

    $("#end").click(function(){

        $.post(BASE+'/end_turn',
                {user_id: user_id,
                 game_id: game_id},
                 function(result){
                    location.reload();
                 }
        );
    });
});