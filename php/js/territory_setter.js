/*********************************************************
 *Initializes a Graph instance, and sets the nodes and edges.
 *********************************************************/

var graph = new Graph();

$(document).ready(function(){
    for(i=0; i <= 41; i++){
        
        var name = $("#terr"+i).attr('name');
        $("#terr"+i).append('<p>'+name+'</p>');
        graph.add_node(name, {}, []);
    }
    
    //alaska 1
    graph.add_edges(graph._node_list[0].id, graph._node_list[1].id);
    graph.add_edges(graph._node_list[0].id, graph._node_list[6].id);
    graph.add_edges(graph._node_list[0].id, graph._node_list[31].id);
   
    //nw_territory
    graph.add_edges(graph._node_list[6].id, graph._node_list[0].id);
    graph.add_edges(graph._node_list[6].id, graph._node_list[1].id);
    graph.add_edges(graph._node_list[6].id, graph._node_list[7].id);
    
    //alberta
    graph.add_edges(graph._node_list[1].id, graph._node_list[6].id);
    graph.add_edges(graph._node_list[1].id, graph._node_list[0].id);
    graph.add_edges(graph._node_list[1].id, graph._node_list[7].id);
    graph.add_edges(graph._node_list[1].id, graph._node_list[4].id);
    
    //ontario
    graph.add_edges(graph._node_list[7].id, graph._node_list[1].id);
    graph.add_edges(graph._node_list[7].id, graph._node_list[6].id);
    graph.add_edges(graph._node_list[7].id, graph._node_list[4].id);
    graph.add_edges(graph._node_list[7].id, graph._node_list[8].id);
    graph.add_edges(graph._node_list[7].id, graph._node_list[3].id);
    graph.add_edges(graph._node_list[7].id, graph._node_list[5].id);
    
    //quebec
    graph.add_edges(graph._node_list[8].id, graph._node_list[5].id);
    graph.add_edges(graph._node_list[8].id, graph._node_list[7].id);
    graph.add_edges(graph._node_list[8].id, graph._node_list[3].id);
   
    //greenland
    graph.add_edges(graph._node_list[5].id, graph._node_list[8].id);
    graph.add_edges(graph._node_list[5].id, graph._node_list[7].id);
    graph.add_edges(graph._node_list[5].id, graph._node_list[6].id);
    graph.add_edges(graph._node_list[5].id, graph._node_list[14].id);
    
    //eastern_us
    graph.add_edges(graph._node_list[3].id, graph._node_list[8].id);
    graph.add_edges(graph._node_list[3].id, graph._node_list[7].id);
    graph.add_edges(graph._node_list[3].id, graph._node_list[4].id);
    
    //western_us
    graph.add_edges(graph._node_list[4].id, graph._node_list[3].id);
    graph.add_edges(graph._node_list[4].id, graph._node_list[7].id);
    graph.add_edges(graph._node_list[4].id, graph._node_list[1].id);
    graph.add_edges(graph._node_list[4].id, graph._node_list[2].id);
    
    //central_america
    graph.add_edges(graph._node_list[2].id, graph._node_list[4].id);
    graph.add_edges(graph._node_list[2].id, graph._node_list[12].id);
    
    //venezuela
    graph.add_edges(graph._node_list[12].id, graph._node_list[2].id);
    graph.add_edges(graph._node_list[12].id, graph._node_list[11].id);
    graph.add_edges(graph._node_list[12].id, graph._node_list[10].id);
    
    //peru
    graph.add_edges(graph._node_list[11].id, graph._node_list[12].id);
    graph.add_edges(graph._node_list[11].id, graph._node_list[10].id);
    graph.add_edges(graph._node_list[11].id, graph._node_list[9].id);
    
    //argentina
    graph.add_edges(graph._node_list[9].id, graph._node_list[11].id);
    graph.add_edges(graph._node_list[9].id, graph._node_list[10].id);
    
    //brazil
    graph.add_edges(graph._node_list[10].id, graph._node_list[12].id);
    graph.add_edges(graph._node_list[10].id, graph._node_list[11].id);
    graph.add_edges(graph._node_list[10].id, graph._node_list[9].id);
    
    //great_britain
    graph.add_edges(graph._node_list[13].id, graph._node_list[14].id);
    graph.add_edges(graph._node_list[13].id, graph._node_list[15].id);
    graph.add_edges(graph._node_list[13].id, graph._node_list[16].id);
    graph.add_edges(graph._node_list[13].id, graph._node_list[19].id);
    
    //iceland
    graph.add_edges(graph._node_list[14].id, graph._node_list[5].id);
    graph.add_edges(graph._node_list[14].id, graph._node_list[13].id);
    graph.add_edges(graph._node_list[14].id, graph._node_list[16].id);
    
    //scandinavia
    graph.add_edges(graph._node_list[16].id, graph._node_list[13].id);
    graph.add_edges(graph._node_list[16].id, graph._node_list[14].id);
    graph.add_edges(graph._node_list[16].id, graph._node_list[15].id);
    graph.add_edges(graph._node_list[16].id, graph._node_list[18].id);
    
    //northern_eur
    graph.add_edges(graph._node_list[15].id, graph._node_list[13].id);
    graph.add_edges(graph._node_list[15].id, graph._node_list[19].id);
    graph.add_edges(graph._node_list[15].id, graph._node_list[16].id);
    graph.add_edges(graph._node_list[15].id, graph._node_list[17].id);
    graph.add_edges(graph._node_list[15].id, graph._node_list[18].id);

    //southern_eur
    graph.add_edges(graph._node_list[17].id, graph._node_list[15].id);
    graph.add_edges(graph._node_list[17].id, graph._node_list[18].id);
    graph.add_edges(graph._node_list[17].id, graph._node_list[19].id);
    graph.add_edges(graph._node_list[17].id, graph._node_list[22].id);
    graph.add_edges(graph._node_list[17].id, graph._node_list[24].id);
    
    //western_eur
    graph.add_edges(graph._node_list[19].id, graph._node_list[13].id);
    graph.add_edges(graph._node_list[19].id, graph._node_list[15].id);
    graph.add_edges(graph._node_list[19].id, graph._node_list[17].id);
    graph.add_edges(graph._node_list[19].id, graph._node_list[24].id);

    //ukraine
    graph.add_edges(graph._node_list[18].id, graph._node_list[15].id);
    graph.add_edges(graph._node_list[18].id, graph._node_list[16].id);
    graph.add_edges(graph._node_list[18].id, graph._node_list[17].id);
    graph.add_edges(graph._node_list[18].id, graph._node_list[26].id);
    graph.add_edges(graph._node_list[18].id, graph._node_list[32].id);
    graph.add_edges(graph._node_list[18].id, graph._node_list[35].id);
    
    //north_africa
    graph.add_edges(graph._node_list[24].id, graph._node_list[10].id);
    graph.add_edges(graph._node_list[24].id, graph._node_list[19].id);
    graph.add_edges(graph._node_list[24].id, graph._node_list[17].id);
    graph.add_edges(graph._node_list[24].id, graph._node_list[22].id);
    graph.add_edges(graph._node_list[24].id, graph._node_list[20].id);
    
    //congo
    graph.add_edges(graph._node_list[20].id, graph._node_list[24].id);
    graph.add_edges(graph._node_list[20].id, graph._node_list[22].id);
    graph.add_edges(graph._node_list[20].id, graph._node_list[21].id);
    graph.add_edges(graph._node_list[20].id, graph._node_list[25].id);
    
    //south_africa
    graph.add_edges(graph._node_list[25].id, graph._node_list[20].id);
    graph.add_edges(graph._node_list[25].id, graph._node_list[21].id);
    graph.add_edges(graph._node_list[25].id, graph._node_list[23].id);
    
    //madagascar
    graph.add_edges(graph._node_list[23].id, graph._node_list[25].id);
    graph.add_edges(graph._node_list[23].id, graph._node_list[21].id);
    
    //east_africa
    graph.add_edges(graph._node_list[21].id, graph._node_list[25].id);
    graph.add_edges(graph._node_list[21].id, graph._node_list[23].id);
    graph.add_edges(graph._node_list[21].id, graph._node_list[20].id);
    graph.add_edges(graph._node_list[21].id, graph._node_list[22].id);
    
    //egypt
    graph.add_edges(graph._node_list[22].id, graph._node_list[21].id);
    graph.add_edges(graph._node_list[22].id, graph._node_list[20].id);
    graph.add_edges(graph._node_list[22].id, graph._node_list[24].id);
    graph.add_edges(graph._node_list[22].id, graph._node_list[17].id);
    graph.add_edges(graph._node_list[22].id, graph._node_list[32].id);
    
    //middle_east
    graph.add_edges(graph._node_list[32].id, graph._node_list[22].id);
    graph.add_edges(graph._node_list[32].id, graph._node_list[18].id);
    graph.add_edges(graph._node_list[32].id, graph._node_list[26].id);
    graph.add_edges(graph._node_list[32].id, graph._node_list[28].id);
    
    //afghanistan
    graph.add_edges(graph._node_list[26].id, graph._node_list[32].id);
    graph.add_edges(graph._node_list[26].id, graph._node_list[18].id);
    graph.add_edges(graph._node_list[26].id, graph._node_list[35].id);
    graph.add_edges(graph._node_list[26].id, graph._node_list[28].id);
    graph.add_edges(graph._node_list[26].id, graph._node_list[27].id);
    graph.add_edges(graph._node_list[26].id, graph._node_list[34].id);
    
    //ural
    graph.add_edges(graph._node_list[35].id, graph._node_list[18].id);
    graph.add_edges(graph._node_list[26].id, graph._node_list[26].id);
    graph.add_edges(graph._node_list[26].id, graph._node_list[34].id);
    
    //siberia
    graph.add_edges(graph._node_list[34].id, graph._node_list[35].id);
    graph.add_edges(graph._node_list[34].id, graph._node_list[26].id);
    graph.add_edges(graph._node_list[34].id, graph._node_list[27].id);
    graph.add_edges(graph._node_list[34].id, graph._node_list[37].id);
    graph.add_edges(graph._node_list[34].id, graph._node_list[29].id);
    graph.add_edges(graph._node_list[34].id, graph._node_list[36].id);
    
    //china
    graph.add_edges(graph._node_list[27].id, graph._node_list[34].id);
    graph.add_edges(graph._node_list[27].id, graph._node_list[37].id);
    graph.add_edges(graph._node_list[27].id, graph._node_list[28].id);
    graph.add_edges(graph._node_list[27].id, graph._node_list[33].id);
    graph.add_edges(graph._node_list[27].id, graph._node_list[26].id);
    
    //india
    graph.add_edges(graph._node_list[28].id, graph._node_list[27].id);
    graph.add_edges(graph._node_list[28].id, graph._node_list[33].id);
    graph.add_edges(graph._node_list[28].id, graph._node_list[32].id);
    graph.add_edges(graph._node_list[28].id, graph._node_list[26].id);
    
    //siam
    graph.add_edges(graph._node_list[33].id, graph._node_list[28].id);
    graph.add_edges(graph._node_list[33].id, graph._node_list[27].id);
    graph.add_edges(graph._node_list[33].id, graph._node_list[39].id);
    
    //mongolia
    graph.add_edges(graph._node_list[37].id, graph._node_list[27].id);
    graph.add_edges(graph._node_list[37].id, graph._node_list[34].id);
    graph.add_edges(graph._node_list[37].id, graph._node_list[29].id);
    graph.add_edges(graph._node_list[37].id, graph._node_list[31].id);
    graph.add_edges(graph._node_list[37].id, graph._node_list[30].id);
    
    //irkutsk
    graph.add_edges(graph._node_list[29].id, graph._node_list[37].id);
    graph.add_edges(graph._node_list[29].id, graph._node_list[31].id);
    graph.add_edges(graph._node_list[29].id, graph._node_list[36].id);
    graph.add_edges(graph._node_list[29].id, graph._node_list[34].id);
    
    //yakutsk
    graph.add_edges(graph._node_list[36].id, graph._node_list[34].id);
    graph.add_edges(graph._node_list[36].id, graph._node_list[29].id);
    graph.add_edges(graph._node_list[36].id, graph._node_list[31].id);
    
    //kamchatka
    graph.add_edges(graph._node_list[31].id, graph._node_list[36].id);
    graph.add_edges(graph._node_list[31].id, graph._node_list[29].id);
    graph.add_edges(graph._node_list[31].id, graph._node_list[37].id);
    graph.add_edges(graph._node_list[31].id, graph._node_list[0].id);
    graph.add_edges(graph._node_list[31].id, graph._node_list[30].id);
    
    //japan
    graph.add_edges(graph._node_list[30].id, graph._node_list[31].id);
    graph.add_edges(graph._node_list[30].id, graph._node_list[37].id);
    
    //indonesia
    graph.add_edges(graph._node_list[39].id, graph._node_list[33].id);
    graph.add_edges(graph._node_list[39].id, graph._node_list[40].id);
    graph.add_edges(graph._node_list[39].id, graph._node_list[41].id);
    
    //west_australia
    graph.add_edges(graph._node_list[41].id, graph._node_list[39].id);
    graph.add_edges(graph._node_list[41].id, graph._node_list[40].id);
    graph.add_edges(graph._node_list[41].id, graph._node_list[38].id);
    
    //east_australia
    graph.add_edges(graph._node_list[38].id, graph._node_list[41].id);
    graph.add_edges(graph._node_list[38].id, graph._node_list[40].id);
    
    //new_guinea
    graph.add_edges(graph._node_list[40].id, graph._node_list[38].id);
    graph.add_edges(graph._node_list[40].id, graph._node_list[41].id);
    graph.add_edges(graph._node_list[40].id, graph._node_list[39].id);
    
    //probably make into different file.
    //this code fires after all players have joined or mod has initiated.
    
    if (typeof game_state !== "undefined" && typeof plyr_nm_color !== "undefined") {
     
        for(i=0; i <= 41; i++){
            var name = $("#"+game_state[i].terr).attr('name');
            var color = "";
          
            graph.update_data(name, {owner_name: game_state[i].owner, armies: game_state[i].army_cnt, pk_id: (i+1)});

            for (j=0; j < plyr_nm_color.length; j++) {

                if(game_state[i].owner == plyr_nm_color[j].fn){
                    color = plyr_nm_color[j].color;
                    graph._node_list[i].data.color = color;
                }
            }

            var orig_armycnt =  game_state[i].army_cnt;
            
            if(armies_plcd === 1 || user_fn !== graph._node_list[i].data.owner_name)
                $("#terr"+i).html('<p style="font-style:bold; color:'+color+';">'+graph._node_list[i].data.armies+'</p>');  
            
            else if(user_fn === graph._node_list[i].data.owner_name){

                 $("#terr"+i).html('<input id="armies'+i+'" type="text" size="2" value = "'+graph._node_list[i].data.armies+'">\
                                    <input id="place'+i+'" type="button" value="place">\
                                    <script type="text/javascript">\
                                            $("#place'+i+'").ready(function(){\
                                                    $("#place'+i+'").click(function(){\
                                                        var added_armies = $("#armies'+i+'").val() - '+orig_armycnt+';\
                                                        if(parseInt(added_armies) <= init_armies && parseInt($("#armies'+i+'").val()) > 0){\
                                                            $.post("'+BASE+'/place",\
                                                                    {armies: added_armies,\
                                                                     uid: uid,\
                                                                     game_id: game_id,\
                                                                     terr_num: '+i+',\
                                                                     game_table: game_table},\
                                                                    function(result){\
                                                                        $("#place_armies").html("<p>"+result+" ARMIES REMANING</p>");\
                                                                        init_armies = result;\
                                                            });\
                                                         }\
                                                         else{\
                                                            if(parseInt($("#armies'+i+'").val()) > 0)\
                                                                alert("TOO MANY ARMIES, FOOL!");\
                                                            else\
                                                                alert("TOO FEW ARMIES, CRETEN!");\
                                                        }\
                                                    });\
                                            });\
                                    </script>');
            }
        }
    }
});
