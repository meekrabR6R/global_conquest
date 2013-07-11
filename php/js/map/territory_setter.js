/*********************************************************
 *Initializes a graph instance, and sets the nodes and edges. 
 *********************************************************/
GameSpace.graph = new Graph();

GameSpace.setUpPlayers = function(){

    if (GameSpace.game_state.length > 0 && typeof GameSpace.plyr_nm_color !== "undefined") {
        
        for(i=0; i <= 41; i++){
            var name = $("#"+GameSpace.game_state[i].terr).attr('name');
            var color = "";
          
            GameSpace.graph.add_data(name, {owner_id: GameSpace.game_state[i].owner_id, armies: GameSpace.game_state[i].army_cnt, pk_id: (i+1)});

            for (j=0; j < GameSpace.plyr_nm_color.length; j++) {

                if(GameSpace.game_state[i].owner_id == GameSpace.plyr_nm_color[j].plyr_id){
                    color = GameSpace.plyr_nm_color[j].color;
                    GameSpace.graph._node_list[i].data.color = color;
                }
            }

            var orig_armycnt =  GameSpace.game_state[i].army_cnt;
            
            $("#terr"+i).html('<h3 style="color:'+color+';">'+GameSpace.graph._node_list[i].data.armies+'</h3>');  
            
            
        }
    }
};

GameSpace.setTerritories = function(){

    //alaska 1
    GameSpace.graph.add_edges(GameSpace.graph._node_list[0].id, GameSpace.graph._node_list[1].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[0].id, GameSpace.graph._node_list[6].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[0].id, GameSpace.graph._node_list[31].id);
   
    //nw_territory
    GameSpace.graph.add_edges(GameSpace.graph._node_list[6].id, GameSpace.graph._node_list[0].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[6].id, GameSpace.graph._node_list[1].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[6].id, GameSpace.graph._node_list[7].id);
    
    //alberta
    GameSpace.graph.add_edges(GameSpace.graph._node_list[1].id, GameSpace.graph._node_list[6].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[1].id, GameSpace.graph._node_list[0].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[1].id, GameSpace.graph._node_list[7].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[1].id, GameSpace.graph._node_list[4].id);
    
    //ontario
    GameSpace.graph.add_edges(GameSpace.graph._node_list[7].id, GameSpace.graph._node_list[1].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[7].id, GameSpace.graph._node_list[6].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[7].id, GameSpace.graph._node_list[4].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[7].id, GameSpace.graph._node_list[8].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[7].id, GameSpace.graph._node_list[3].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[7].id, GameSpace.graph._node_list[5].id);
    
    //quebec
    GameSpace.graph.add_edges(GameSpace.graph._node_list[8].id, GameSpace.graph._node_list[5].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[8].id, GameSpace.graph._node_list[7].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[8].id, GameSpace.graph._node_list[3].id);
   
    //greenland
    GameSpace.graph.add_edges(GameSpace.graph._node_list[5].id, GameSpace.graph._node_list[8].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[5].id, GameSpace.graph._node_list[7].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[5].id, GameSpace.graph._node_list[6].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[5].id, GameSpace.graph._node_list[14].id);
    
    //eastern_us
    GameSpace.graph.add_edges(GameSpace.graph._node_list[3].id, GameSpace.graph._node_list[8].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[3].id, GameSpace.graph._node_list[7].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[3].id, GameSpace.graph._node_list[4].id);
    
    //western_us
    GameSpace.graph.add_edges(GameSpace.graph._node_list[4].id, GameSpace.graph._node_list[3].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[4].id, GameSpace.graph._node_list[7].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[4].id, GameSpace.graph._node_list[1].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[4].id, GameSpace.graph._node_list[2].id);
    
    //central_america
    GameSpace.graph.add_edges(GameSpace.graph._node_list[2].id, GameSpace.graph._node_list[4].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[2].id, GameSpace.graph._node_list[12].id);
    
    //venezuela
    GameSpace.graph.add_edges(GameSpace.graph._node_list[12].id, GameSpace.graph._node_list[2].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[12].id, GameSpace.graph._node_list[11].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[12].id, GameSpace.graph._node_list[10].id);
    
    //peru
    GameSpace.graph.add_edges(GameSpace.graph._node_list[11].id, GameSpace.graph._node_list[12].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[11].id, GameSpace.graph._node_list[10].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[11].id, GameSpace.graph._node_list[9].id);
    
    //argentina
    GameSpace.graph.add_edges(GameSpace.graph._node_list[9].id, GameSpace.graph._node_list[11].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[9].id, GameSpace.graph._node_list[10].id);
    
    //brazil
    GameSpace.graph.add_edges(GameSpace.graph._node_list[10].id, GameSpace.graph._node_list[12].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[10].id, GameSpace.graph._node_list[11].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[10].id, GameSpace.graph._node_list[9].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[10].id, GameSpace.graph._node_list[24].id);  
    //great_britain
    GameSpace.graph.add_edges(GameSpace.graph._node_list[13].id, GameSpace.graph._node_list[14].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[13].id, GameSpace.graph._node_list[15].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[13].id, GameSpace.graph._node_list[16].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[13].id, GameSpace.graph._node_list[19].id);
    
    //iceland
    GameSpace.graph.add_edges(GameSpace.graph._node_list[14].id, GameSpace.graph._node_list[5].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[14].id, GameSpace.graph._node_list[13].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[14].id, GameSpace.graph._node_list[16].id);
    
    //scandinavia
    GameSpace.graph.add_edges(GameSpace.graph._node_list[16].id, GameSpace.graph._node_list[13].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[16].id, GameSpace.graph._node_list[14].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[16].id, GameSpace.graph._node_list[15].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[16].id, GameSpace.graph._node_list[18].id);
    
    //northern_eur
    GameSpace.graph.add_edges(GameSpace.graph._node_list[15].id, GameSpace.graph._node_list[13].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[15].id, GameSpace.graph._node_list[19].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[15].id, GameSpace.graph._node_list[16].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[15].id, GameSpace.graph._node_list[17].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[15].id, GameSpace.graph._node_list[18].id);

    //southern_eur
    GameSpace.graph.add_edges(GameSpace.graph._node_list[17].id, GameSpace.graph._node_list[15].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[17].id, GameSpace.graph._node_list[18].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[17].id, GameSpace.graph._node_list[19].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[17].id, GameSpace.graph._node_list[22].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[17].id, GameSpace.graph._node_list[24].id);
    
    //western_eur
    GameSpace.graph.add_edges(GameSpace.graph._node_list[19].id, GameSpace.graph._node_list[13].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[19].id, GameSpace.graph._node_list[15].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[19].id, GameSpace.graph._node_list[17].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[19].id, GameSpace.graph._node_list[24].id);

    //ukraine
    GameSpace.graph.add_edges(GameSpace.graph._node_list[18].id, GameSpace.graph._node_list[15].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[18].id, GameSpace.graph._node_list[16].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[18].id, GameSpace.graph._node_list[17].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[18].id, GameSpace.graph._node_list[26].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[18].id, GameSpace.graph._node_list[32].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[18].id, GameSpace.graph._node_list[35].id);
    
    //north_africa
    GameSpace.graph.add_edges(GameSpace.graph._node_list[24].id, GameSpace.graph._node_list[10].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[24].id, GameSpace.graph._node_list[19].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[24].id, GameSpace.graph._node_list[17].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[24].id, GameSpace.graph._node_list[22].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[24].id, GameSpace.graph._node_list[20].id);
    
    //congo
    GameSpace.graph.add_edges(GameSpace.graph._node_list[20].id, GameSpace.graph._node_list[24].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[20].id, GameSpace.graph._node_list[22].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[20].id, GameSpace.graph._node_list[21].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[20].id, GameSpace.graph._node_list[25].id);
    
    //south_africa
    GameSpace.graph.add_edges(GameSpace.graph._node_list[25].id, GameSpace.graph._node_list[20].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[25].id, GameSpace.graph._node_list[21].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[25].id, GameSpace.graph._node_list[23].id);
    
    //madagascar
    GameSpace.graph.add_edges(GameSpace.graph._node_list[23].id, GameSpace.graph._node_list[25].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[23].id, GameSpace.graph._node_list[21].id);
    
    //east_africa
    GameSpace.graph.add_edges(GameSpace.graph._node_list[21].id, GameSpace.graph._node_list[25].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[21].id, GameSpace.graph._node_list[23].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[21].id, GameSpace.graph._node_list[20].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[21].id, GameSpace.graph._node_list[22].id);
    
    //egypt
    GameSpace.graph.add_edges(GameSpace.graph._node_list[22].id, GameSpace.graph._node_list[21].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[22].id, GameSpace.graph._node_list[20].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[22].id, GameSpace.graph._node_list[24].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[22].id, GameSpace.graph._node_list[17].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[22].id, GameSpace.graph._node_list[32].id);
    
    //middle_east
    GameSpace.graph.add_edges(GameSpace.graph._node_list[32].id, GameSpace.graph._node_list[22].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[32].id, GameSpace.graph._node_list[18].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[32].id, GameSpace.graph._node_list[26].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[32].id, GameSpace.graph._node_list[28].id);
    
    //afghanistan
    GameSpace.graph.add_edges(GameSpace.graph._node_list[26].id, GameSpace.graph._node_list[32].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[26].id, GameSpace.graph._node_list[18].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[26].id, GameSpace.graph._node_list[35].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[26].id, GameSpace.graph._node_list[28].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[26].id, GameSpace.graph._node_list[27].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[26].id, GameSpace.graph._node_list[34].id);
    
    //ural
    GameSpace.graph.add_edges(GameSpace.graph._node_list[35].id, GameSpace.graph._node_list[18].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[35].id, GameSpace.graph._node_list[26].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[35].id, GameSpace.graph._node_list[34].id);
    
    //siberia
    GameSpace.graph.add_edges(GameSpace.graph._node_list[34].id, GameSpace.graph._node_list[35].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[34].id, GameSpace.graph._node_list[26].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[34].id, GameSpace.graph._node_list[27].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[34].id, GameSpace.graph._node_list[37].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[34].id, GameSpace.graph._node_list[29].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[34].id, GameSpace.graph._node_list[36].id);
    
    //china
    GameSpace.graph.add_edges(GameSpace.graph._node_list[27].id, GameSpace.graph._node_list[34].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[27].id, GameSpace.graph._node_list[37].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[27].id, GameSpace.graph._node_list[28].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[27].id, GameSpace.graph._node_list[33].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[27].id, GameSpace.graph._node_list[26].id);
    
    //india
    GameSpace.graph.add_edges(GameSpace.graph._node_list[28].id, GameSpace.graph._node_list[27].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[28].id, GameSpace.graph._node_list[33].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[28].id, GameSpace.graph._node_list[32].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[28].id, GameSpace.graph._node_list[26].id);
    
    //siam
    GameSpace.graph.add_edges(GameSpace.graph._node_list[33].id, GameSpace.graph._node_list[28].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[33].id, GameSpace.graph._node_list[27].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[33].id, GameSpace.graph._node_list[39].id);
    
    //mongolia
    GameSpace.graph.add_edges(GameSpace.graph._node_list[37].id, GameSpace.graph._node_list[27].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[37].id, GameSpace.graph._node_list[34].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[37].id, GameSpace.graph._node_list[29].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[37].id, GameSpace.graph._node_list[31].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[37].id, GameSpace.graph._node_list[30].id);
    
    //irkutsk
    GameSpace.graph.add_edges(GameSpace.graph._node_list[29].id, GameSpace.graph._node_list[37].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[29].id, GameSpace.graph._node_list[31].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[29].id, GameSpace.graph._node_list[36].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[29].id, GameSpace.graph._node_list[34].id);
    
    //yakutsk
    GameSpace.graph.add_edges(GameSpace.graph._node_list[36].id, GameSpace.graph._node_list[34].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[36].id, GameSpace.graph._node_list[29].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[36].id, GameSpace.graph._node_list[31].id);
    
    //kamchatka
    GameSpace.graph.add_edges(GameSpace.graph._node_list[31].id, GameSpace.graph._node_list[36].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[31].id, GameSpace.graph._node_list[29].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[31].id, GameSpace.graph._node_list[37].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[31].id, GameSpace.graph._node_list[0].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[31].id, GameSpace.graph._node_list[30].id);
    
    //japan
    GameSpace.graph.add_edges(GameSpace.graph._node_list[30].id, GameSpace.graph._node_list[31].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[30].id, GameSpace.graph._node_list[37].id);
    
    //indonesia
    GameSpace.graph.add_edges(GameSpace.graph._node_list[39].id, GameSpace.graph._node_list[33].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[39].id, GameSpace.graph._node_list[40].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[39].id, GameSpace.graph._node_list[41].id);
    
    //west_australia
    GameSpace.graph.add_edges(GameSpace.graph._node_list[41].id, GameSpace.graph._node_list[39].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[41].id, GameSpace.graph._node_list[40].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[41].id, GameSpace.graph._node_list[38].id);
    
    //east_australia
    GameSpace.graph.add_edges(GameSpace.graph._node_list[38].id, GameSpace.graph._node_list[41].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[38].id, GameSpace.graph._node_list[40].id);
    
    //new_guinea
    GameSpace.graph.add_edges(GameSpace.graph._node_list[40].id, GameSpace.graph._node_list[38].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[40].id, GameSpace.graph._node_list[41].id);
    GameSpace.graph.add_edges(GameSpace.graph._node_list[40].id, GameSpace.graph._node_list[39].id);
};

GameSpace.makeRiskMap = function(){
  
    $(document).ready(function(){
    
        for(i=0; i <= 41; i++){
            
            var name = $("#terr"+i).attr('name');
            GameSpace.graph.add_node(name, {}, []);
            
        }

        GameSpace.setTerritories();
        GameSpace.setUpPlayers();
    });
};

GameSpace.pickColors = function(){
  
  $("#color_pick2").ready(function(){
     
     $("#join_btn").click(function(){
         
          $("#color_pick2").html('Choose Color: <select id="color">\
                                   <option name="blue">blue</option>\
                                   <option name="green">green</option>\
                                   </select>\
                                   <input id="submit_col" type="button"  value="submit">');

       $("#submit_col").ready(function(){

          $("#submit_col").click(function(){

               var color =  $("#color").val();
               $.post(GameSpace.BASE+'/join?game_id='+GameSpace.game_id,
                     {uid: GameSpace.user_id,
                      game_id: GameSpace.game_id,
                      plyr_color: color},
                     function(result){
                          console.log(result);
                });
            });
      });

    });

  }); 
}; 


//shit that happens
GameSpace.makeRiskMap();
GameSpace.pickColors();