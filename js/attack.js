
$("#attk_btn").ready(function(){
   
    $("#attk_btn").click(function(){
        
        $('#attk_mode').append('<table><tr><td>\
                             <select id="dice">\
                                <option id="3">3</option>\
                                <option id="2">2</option>\
                                <option id="1">1</option>\
                             </select>\
                             <input id="roll" type="submit" value="roll" onclick="roll_attk()">\
                             <input type="text" value="roll_result">\
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
    Math.floor((Math.random()*6)+1); 
}
function code_click(continent){
        
       $(continent).each(function(){
            
            var node_id = $(this).attr('name');
           
            $(this).click(function(){
        
                border_list = [];
                $("#attack").text(node_id);
                
                graph._node_list.forEach(function(item){
                    if(item.id === node_id){
                        
                        item.edges.forEach(function(border){
                          border_list.push(border);
                        });
                        var options = "";
                        
                        for(i=0; i < border_list.length; i++) 
                            options+="<option id='"+border_list[i]+"'>"+border_list[i]+"</option>";
                        
                        var country_select = "<select id='attackable'>"+options+"</select>";
                      
                        $("#defend").html(country_select);
                    }
                });
                
            });
        }); 
    }