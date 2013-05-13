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
    
    //alaska
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
    
    //probably make into different file. owner name to be replaced with fb name.
    graph.update_data(graph._node_list[0].id,{owner: "Nick", armies: 20, name: "Alaska"});
    graph.update_data(graph._node_list[6].id,{owner: "Frank", armies: 20, name: "NW Territory"});
    graph.update_data(graph._node_list[1].id,{owner: "Nick", armies: 2, name: "Alberta"});
    graph.update_data(graph._node_list[7].id,{owner: "Frank", armies: 1, name: "Ontario"});
    
    for(i=0; i <= 41; i++){
        
        var name = $("#terr"+i).attr('name');
        if(i === 0 || i === 6 || i === 1 || i === 7) {
             if (i === 0 || i === 1) 
                $("#terr"+i).html('<p style="color:pink;">'+graph._node_list[i].data.armies+'</p>');
            if (i === 6 || i === 7) 
                $("#terr"+i).html('<p style="color:blue;">'+graph._node_list[i].data.armies+'</p>');
        }
       
       
    }
    
});
