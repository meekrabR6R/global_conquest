
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

function roll_attk(){
    
    var attk_armies = $("#dice").val();
    var def_armies = 2; //change value
    var attk_roll = [];
    var def_roll = [];
    
    for(i=0; i < attk_armies; i++)
        attk_roll[i] = Math.floor((Math.random()*6)+1);
    
    for(i=0; i < def_armies; i++)
        def_roll[i] = Math.floor((Math.random()*6)+1);
    
}

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
                                        <input type="text" value="roll_result">');
                    
                    var terr_options = "";     
                    for(i=0; i < border_list.length; i++) 
                        terr_options+="<option id='"+border_list[i]+"'>"+border_list[i]+"</option>";
                            
                    var country_select = "<select id='attackable'>"+terr_options+"</select>";  
                    $("#defend").html(country_select);
                }
                else
                    alert("Select a country with more than 1 ARMY.");
            });
                
                
        });
        
}