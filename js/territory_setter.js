var graph = new Graph();

$(document).ready(function(){
    for(i=0; i <= 41; i++){
        
        var name = $("#terr"+i).attr('name');
        $("#terr"+i).append('<p>'+name+'</p>');
        graph.add_node(name, {}, []);
    }
    
    //0 alaska
    graph.add_edges(graph._node_list[0].id, graph._node_list[1].id);
    graph.add_edges(graph._node_list[0].id, graph._node_list[6].id);
    graph.add_edges(graph._node_list[0].id, graph._node_list[31].id);
   
    //1 nw_territory
    graph.add_edges(graph._node_list[6].id, graph._node_list[0].id);
    graph.add_edges(graph._node_list[6].id, graph._node_list[1].id);
    graph.add_edges(graph._node_list[6].id, graph._node_list[7].id);
    
    //2 alberta
    graph.add_edges(graph._node_list[1].id, graph._node_list[6].id);
    graph.add_edges(graph._node_list[1].id, graph._node_list[0].id);
    graph.add_edges(graph._node_list[1].id, graph._node_list[7].id);
    graph.add_edges(graph._node_list[1].id, graph._node_list[4].id);
    
    //3 ontario
    graph.add_edges(graph._node_list[7].id, graph._node_list[1].id);
    graph.add_edges(graph._node_list[7].id, graph._node_list[6].id);
    graph.add_edges(graph._node_list[7].id, graph._node_list[4].id);
    graph.add_edges(graph._node_list[7].id, graph._node_list[8].id);
    graph.add_edges(graph._node_list[7].id, graph._node_list[3].id);
    graph.add_edges(graph._node_list[7].id, graph._node_list[5].id);
    
    //4 quebec
    graph.add_edges(graph._node_list[8].id, graph._node_list[5].id);
    graph.add_edges(graph._node_list[8].id, graph._node_list[7].id);
    graph.add_edges(graph._node_list[8].id, graph._node_list[3].id);
   
    //5 greenland
    graph.add_edges(graph._node_list[5].id, graph._node_list[8].id);
    graph.add_edges(graph._node_list[5].id, graph._node_list[7].id);
    graph.add_edges(graph._node_list[5].id, graph._node_list[6].id);
    graph.add_edges(graph._node_list[5].id, graph._node_list[14].id);
    
    //6 eastern_us
    graph.add_edges(graph._node_list[3].id, graph._node_list[8].id);
    graph.add_edges(graph._node_list[3].id, graph._node_list[7].id);
    graph.add_edges(graph._node_list[3].id, graph._node_list[4].id);
    
    //7 western_us
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
    
});
