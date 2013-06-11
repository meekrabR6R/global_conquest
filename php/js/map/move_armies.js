
$("#mov_btn").ready(function(){
    
    $("#mov_btn").click(function(){
        
        $('#attk_btn').attr("disabled", true);
        $('#mov_btn').attr("disabled", true);
      	set_clicks();
        
        $('#mov_mode').append('<table><tr><td>\
                             <div id="select_from">SELECT COUNTRY</div>\
                           </td>\
                        </tr>\
                        <tr>\
                        <td>\
                        	<div id="select_to"></div>\
                        </td>\
                        </tr>');
        	
    });    
});

function move_click(continent){
        
       $(continent).each(function(){
            
            var node = graph.get_node($(this).attr('name'));
          
            if(node.data.owner_id === user_id){   
               
                $(this).click(function(){
                    
                    border_list = [];
                    $("#select_from").text('From: ' + node.id);
                    
                    node.edges.forEach(function(border){
                        var border_node = graph.get_node(border); 
                        
                        if(border_node.data.owner_id !== node.data.owner_id) 
                            border_list.push(border);
                                
                    });
                    
                    if(node.data.armies > 1) {
                      
                        var armies = "";
                       
                        for(i=1; i < node.data.armies; i++){
                            armies += '<option id="'+i+'">'+i+'</option>';
                           
                        }
                        
                        $("#select_from").append('<select id="mov_armies">'+armies+'</select>');
                        
                        var mov_options = "";
                                                
                        for(i=0; i < border_list.length; i++) 
                            mov_options+="<option id='"+border_list[i]+"'>"+border_list[i]+"</option>";
                                
                        var country_select = "<select id='movable'>"+mov_options+"</select>";  
                        $("#select_to").append();
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