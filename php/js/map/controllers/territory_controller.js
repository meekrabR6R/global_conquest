/**************************************
* Territory Controller
***************************************/

//Constructor
function TerritoryController(territory, mapView){
	this._territory = territory;
	this._map = mapView;
}

TerritoryController.prototype = {

	//adds nodes to this._territory of territories
	addNodes: function(){

		for(i=0; i <= 41; i++){ //upper-bound of for-loop should be replaced with length of list/array/whatever pulled from server
        
	        var name = $("#terr"+i).attr('name'); //this data should come from the server (maybe a territory table?)
	        $("#terr"+i).append('<p>'+name+'</p>');
	        this._territory.add_node(name); 
        }
    
	}

	//connects nodes in this._territory
	addEdges: function(){

		//alaska 1
	    this._territory.add_edges(this._territory._node_list[0].id, this._territory._node_list[1].id);
	    this._territory.add_edges(this._territory._node_list[0].id, this._territory._node_list[6].id);
	    this._territory.add_edges(this._territory._node_list[0].id, this._territory._node_list[31].id);
	   
	    //nw_territory
	    this._territory.add_edges(this._territory._node_list[6].id, this._territory._node_list[0].id);
	    this._territory.add_edges(this._territory._node_list[6].id, this._territory._node_list[1].id);
	    this._territory.add_edges(this._territory._node_list[6].id, this._territory._node_list[7].id);
	    
	    //alberta
	    this._territory.add_edges(this._territory._node_list[1].id, this._territory._node_list[6].id);
	    this._territory.add_edges(this._territory._node_list[1].id, this._territory._node_list[0].id);
	    this._territory.add_edges(this._territory._node_list[1].id, this._territory._node_list[7].id);
	    this._territory.add_edges(this._territory._node_list[1].id, this._territory._node_list[4].id);
	    
	    //ontario
	    this._territory.add_edges(this._territory._node_list[7].id, this._territory._node_list[1].id);
	    this._territory.add_edges(this._territory._node_list[7].id, this._territory._node_list[6].id);
	    this._territory.add_edges(this._territory._node_list[7].id, this._territory._node_list[4].id);
	    this._territory.add_edges(this._territory._node_list[7].id, this._territory._node_list[8].id);
	    this._territory.add_edges(this._territory._node_list[7].id, this._territory._node_list[3].id);
	    this._territory.add_edges(this._territory._node_list[7].id, this._territory._node_list[5].id);
	    
	    //quebec
	    this._territory.add_edges(this._territory._node_list[8].id, this._territory._node_list[5].id);
	    this._territory.add_edges(this._territory._node_list[8].id, this._territory._node_list[7].id);
	    this._territory.add_edges(this._territory._node_list[8].id, this._territory._node_list[3].id);
	   
	    //greenland
	    this._territory.add_edges(this._territory._node_list[5].id, this._territory._node_list[8].id);
	    this._territory.add_edges(this._territory._node_list[5].id, this._territory._node_list[7].id);
	    this._territory.add_edges(this._territory._node_list[5].id, this._territory._node_list[6].id);
	    this._territory.add_edges(this._territory._node_list[5].id, this._territory._node_list[14].id);
	    
	    //eastern_us
	    this._territory.add_edges(this._territory._node_list[3].id, this._territory._node_list[8].id);
	    this._territory.add_edges(this._territory._node_list[3].id, this._territory._node_list[7].id);
	    this._territory.add_edges(this._territory._node_list[3].id, this._territory._node_list[4].id);
	    
	    //western_us
	    this._territory.add_edges(this._territory._node_list[4].id, this._territory._node_list[3].id);
	    this._territory.add_edges(this._territory._node_list[4].id, this._territory._node_list[7].id);
	    this._territory.add_edges(this._territory._node_list[4].id, this._territory._node_list[1].id);
	    this._territory.add_edges(this._territory._node_list[4].id, this._territory._node_list[2].id);
	    
	    //central_america
	    this._territory.add_edges(this._territory._node_list[2].id, this._territory._node_list[4].id);
	    this._territory.add_edges(this._territory._node_list[2].id, this._territory._node_list[12].id);
	    
	    //venezuela
	    this._territory.add_edges(this._territory._node_list[12].id, this._territory._node_list[2].id);
	    this._territory.add_edges(this._territory._node_list[12].id, this._territory._node_list[11].id);
	    this._territory.add_edges(this._territory._node_list[12].id, this._territory._node_list[10].id);
	    
	    //peru
	    this._territory.add_edges(this._territory._node_list[11].id, this._territory._node_list[12].id);
	    this._territory.add_edges(this._territory._node_list[11].id, this._territory._node_list[10].id);
	    this._territory.add_edges(this._territory._node_list[11].id, this._territory._node_list[9].id);
	    
	    //argentina
	    this._territory.add_edges(this._territory._node_list[9].id, this._territory._node_list[11].id);
	    this._territory.add_edges(this._territory._node_list[9].id, this._territory._node_list[10].id);
	    
	    //brazil
	    this._territory.add_edges(this._territory._node_list[10].id, this._territory._node_list[12].id);
	    this._territory.add_edges(this._territory._node_list[10].id, this._territory._node_list[11].id);
	    this._territory.add_edges(this._territory._node_list[10].id, this._territory._node_list[9].id);
	    
	    //great_britain
	    this._territory.add_edges(this._territory._node_list[13].id, this._territory._node_list[14].id);
	    this._territory.add_edges(this._territory._node_list[13].id, this._territory._node_list[15].id);
	    this._territory.add_edges(this._territory._node_list[13].id, this._territory._node_list[16].id);
	    this._territory.add_edges(this._territory._node_list[13].id, this._territory._node_list[19].id);
	    
	    //iceland
	    this._territory.add_edges(this._territory._node_list[14].id, this._territory._node_list[5].id);
	    this._territory.add_edges(this._territory._node_list[14].id, this._territory._node_list[13].id);
	    this._territory.add_edges(this._territory._node_list[14].id, this._territory._node_list[16].id);
	    
	    //scandinavia
	    this._territory.add_edges(this._territory._node_list[16].id, this._territory._node_list[13].id);
	    this._territory.add_edges(this._territory._node_list[16].id, this._territory._node_list[14].id);
	    this._territory.add_edges(this._territory._node_list[16].id, this._territory._node_list[15].id);
	    this._territory.add_edges(this._territory._node_list[16].id, this._territory._node_list[18].id);
	    
	    //northern_eur
	    this._territory.add_edges(this._territory._node_list[15].id, this._territory._node_list[13].id);
	    this._territory.add_edges(this._territory._node_list[15].id, this._territory._node_list[19].id);
	    this._territory.add_edges(this._territory._node_list[15].id, this._territory._node_list[16].id);
	    this._territory.add_edges(this._territory._node_list[15].id, this._territory._node_list[17].id);
	    this._territory.add_edges(this._territory._node_list[15].id, this._territory._node_list[18].id);

	    //southern_eur
	    this._territory.add_edges(this._territory._node_list[17].id, this._territory._node_list[15].id);
	    this._territory.add_edges(this._territory._node_list[17].id, this._territory._node_list[18].id);
	    this._territory.add_edges(this._territory._node_list[17].id, this._territory._node_list[19].id);
	    this._territory.add_edges(this._territory._node_list[17].id, this._territory._node_list[22].id);
	    this._territory.add_edges(this._territory._node_list[17].id, this._territory._node_list[24].id);
	    
	    //western_eur
	    this._territory.add_edges(this._territory._node_list[19].id, this._territory._node_list[13].id);
	    this._territory.add_edges(this._territory._node_list[19].id, this._territory._node_list[15].id);
	    this._territory.add_edges(this._territory._node_list[19].id, this._territory._node_list[17].id);
	    this._territory.add_edges(this._territory._node_list[19].id, this._territory._node_list[24].id);

	    //ukraine
	    this._territory.add_edges(this._territory._node_list[18].id, this._territory._node_list[15].id);
	    this._territory.add_edges(this._territory._node_list[18].id, this._territory._node_list[16].id);
	    this._territory.add_edges(this._territory._node_list[18].id, this._territory._node_list[17].id);
	    this._territory.add_edges(this._territory._node_list[18].id, this._territory._node_list[26].id);
	    this._territory.add_edges(this._territory._node_list[18].id, this._territory._node_list[32].id);
	    this._territory.add_edges(this._territory._node_list[18].id, this._territory._node_list[35].id);
	    
	    //north_africa
	    this._territory.add_edges(this._territory._node_list[24].id, this._territory._node_list[10].id);
	    this._territory.add_edges(this._territory._node_list[24].id, this._territory._node_list[19].id);
	    this._territory.add_edges(this._territory._node_list[24].id, this._territory._node_list[17].id);
	    this._territory.add_edges(this._territory._node_list[24].id, this._territory._node_list[22].id);
	    this._territory.add_edges(this._territory._node_list[24].id, this._territory._node_list[20].id);
	    
	    //congo
	    this._territory.add_edges(this._territory._node_list[20].id, this._territory._node_list[24].id);
	    this._territory.add_edges(this._territory._node_list[20].id, this._territory._node_list[22].id);
	    this._territory.add_edges(this._territory._node_list[20].id, this._territory._node_list[21].id);
	    this._territory.add_edges(this._territory._node_list[20].id, this._territory._node_list[25].id);
	    
	    //south_africa
	    this._territory.add_edges(this._territory._node_list[25].id, this._territory._node_list[20].id);
	    this._territory.add_edges(this._territory._node_list[25].id, this._territory._node_list[21].id);
	    this._territory.add_edges(this._territory._node_list[25].id, this._territory._node_list[23].id);
	    
	    //madagascar
	    this._territory.add_edges(this._territory._node_list[23].id, this._territory._node_list[25].id);
	    this._territory.add_edges(this._territory._node_list[23].id, this._territory._node_list[21].id);
	    
	    //east_africa
	    this._territory.add_edges(this._territory._node_list[21].id, this._territory._node_list[25].id);
	    this._territory.add_edges(this._territory._node_list[21].id, this._territory._node_list[23].id);
	    this._territory.add_edges(this._territory._node_list[21].id, this._territory._node_list[20].id);
	    this._territory.add_edges(this._territory._node_list[21].id, this._territory._node_list[22].id);
	    
	    //egypt
	    this._territory.add_edges(this._territory._node_list[22].id, this._territory._node_list[21].id);
	    this._territory.add_edges(this._territory._node_list[22].id, this._territory._node_list[20].id);
	    this._territory.add_edges(this._territory._node_list[22].id, this._territory._node_list[24].id);
	    this._territory.add_edges(this._territory._node_list[22].id, this._territory._node_list[17].id);
	    this._territory.add_edges(this._territory._node_list[22].id, this._territory._node_list[32].id);
	    
	    //middle_east
	    this._territory.add_edges(this._territory._node_list[32].id, this._territory._node_list[22].id);
	    this._territory.add_edges(this._territory._node_list[32].id, this._territory._node_list[18].id);
	    this._territory.add_edges(this._territory._node_list[32].id, this._territory._node_list[26].id);
	    this._territory.add_edges(this._territory._node_list[32].id, this._territory._node_list[28].id);
	    
	    //afghanistan
	    this._territory.add_edges(this._territory._node_list[26].id, this._territory._node_list[32].id);
	    this._territory.add_edges(this._territory._node_list[26].id, this._territory._node_list[18].id);
	    this._territory.add_edges(this._territory._node_list[26].id, this._territory._node_list[35].id);
	    this._territory.add_edges(this._territory._node_list[26].id, this._territory._node_list[28].id);
	    this._territory.add_edges(this._territory._node_list[26].id, this._territory._node_list[27].id);
	    this._territory.add_edges(this._territory._node_list[26].id, this._territory._node_list[34].id);
	    
	    //ural
	    this._territory.add_edges(this._territory._node_list[35].id, this._territory._node_list[18].id);
	    this._territory.add_edges(this._territory._node_list[26].id, this._territory._node_list[26].id);
	    this._territory.add_edges(this._territory._node_list[26].id, this._territory._node_list[34].id);
	    
	    //siberia
	    this._territory.add_edges(this._territory._node_list[34].id, this._territory._node_list[35].id);
	    this._territory.add_edges(this._territory._node_list[34].id, this._territory._node_list[26].id);
	    this._territory.add_edges(this._territory._node_list[34].id, this._territory._node_list[27].id);
	    this._territory.add_edges(this._territory._node_list[34].id, this._territory._node_list[37].id);
	    this._territory.add_edges(this._territory._node_list[34].id, this._territory._node_list[29].id);
	    this._territory.add_edges(this._territory._node_list[34].id, this._territory._node_list[36].id);
	    
	    //china
	    this._territory.add_edges(this._territory._node_list[27].id, this._territory._node_list[34].id);
	    this._territory.add_edges(this._territory._node_list[27].id, this._territory._node_list[37].id);
	    this._territory.add_edges(this._territory._node_list[27].id, this._territory._node_list[28].id);
	    this._territory.add_edges(this._territory._node_list[27].id, this._territory._node_list[33].id);
	    this._territory.add_edges(this._territory._node_list[27].id, this._territory._node_list[26].id);
	    
	    //india
	    this._territory.add_edges(this._territory._node_list[28].id, this._territory._node_list[27].id);
	    this._territory.add_edges(this._territory._node_list[28].id, this._territory._node_list[33].id);
	    this._territory.add_edges(this._territory._node_list[28].id, this._territory._node_list[32].id);
	    this._territory.add_edges(this._territory._node_list[28].id, this._territory._node_list[26].id);
	    
	    //siam
	    this._territory.add_edges(this._territory._node_list[33].id, this._territory._node_list[28].id);
	    this._territory.add_edges(this._territory._node_list[33].id, this._territory._node_list[27].id);
	    this._territory.add_edges(this._territory._node_list[33].id, this._territory._node_list[39].id);
	    
	    //mongolia
	    this._territory.add_edges(this._territory._node_list[37].id, this._territory._node_list[27].id);
	    this._territory.add_edges(this._territory._node_list[37].id, this._territory._node_list[34].id);
	    this._territory.add_edges(this._territory._node_list[37].id, this._territory._node_list[29].id);
	    this._territory.add_edges(this._territory._node_list[37].id, this._territory._node_list[31].id);
	    this._territory.add_edges(this._territory._node_list[37].id, this._territory._node_list[30].id);
	    
	    //irkutsk
	    this._territory.add_edges(this._territory._node_list[29].id, this._territory._node_list[37].id);
	    this._territory.add_edges(this._territory._node_list[29].id, this._territory._node_list[31].id);
	    this._territory.add_edges(this._territory._node_list[29].id, this._territory._node_list[36].id);
	    this._territory.add_edges(this._territory._node_list[29].id, this._territory._node_list[34].id);
	    
	    //yakutsk
	    this._territory.add_edges(this._territory._node_list[36].id, this._territory._node_list[34].id);
	    this._territory.add_edges(this._territory._node_list[36].id, this._territory._node_list[29].id);
	    this._territory.add_edges(this._territory._node_list[36].id, this._territory._node_list[31].id);
	    
	    //kamchatka
	    this._territory.add_edges(this._territory._node_list[31].id, this._territory._node_list[36].id);
	    this._territory.add_edges(this._territory._node_list[31].id, this._territory._node_list[29].id);
	    this._territory.add_edges(this._territory._node_list[31].id, this._territory._node_list[37].id);
	    this._territory.add_edges(this._territory._node_list[31].id, this._territory._node_list[0].id);
	    this._territory.add_edges(this._territory._node_list[31].id, this._territory._node_list[30].id);
	    
	    //japan
	    this._territory.add_edges(this._territory._node_list[30].id, this._territory._node_list[31].id);
	    this._territory.add_edges(this._territory._node_list[30].id, this._territory._node_list[37].id);
	    
	    //indonesia
	    this._territory.add_edges(this._territory._node_list[39].id, this._territory._node_list[33].id);
	    this._territory.add_edges(this._territory._node_list[39].id, this._territory._node_list[40].id);
	    this._territory.add_edges(this._territory._node_list[39].id, this._territory._node_list[41].id);
	    
	    //west_australia
	    this._territory.add_edges(this._territory._node_list[41].id, this._territory._node_list[39].id);
	    this._territory.add_edges(this._territory._node_list[41].id, this._territory._node_list[40].id);
	    this._territory.add_edges(this._territory._node_list[41].id, this._territory._node_list[38].id);
	    
	    //east_australia
	    this._territory.add_edges(this._territory._node_list[38].id, this._territory._node_list[41].id);
	    this._territory.add_edges(this._territory._node_list[38].id, this._territory._node_list[40].id);
	    
	    //new_guinea
	    this._territory.add_edges(this._territory._node_list[40].id, this._territory._node_list[38].id);
	    this._territory.add_edges(this._territory._node_list[40].id, this._territory._node_list[41].id);
	    this._territory.add_edges(this._territory._node_list[40].id, this._territory._node_list[39].id);

	}

	//This needs a fuck-ton of work...
	updateTerritories: function(game_state, plyr_nm_color, armies_plcd, user_id){

		if (typeof game_state !== "undefined" && typeof plyr_nm_color !== "undefined") {
     
	        for(i=0; i <= 41; i++){
	            var name = $("#"+game_state[i].terr).attr('name');
	            var color = "";
	          
	            this._territory.update_data(name, {owner_id: game_state[i].owner_id, armies: game_state[i].army_cnt, pk_id: (i+1)});//change to territory.etc.etc.

	            for (j=0; j < plyr_nm_color.length; j++) {

	                if(game_state[i].owner_id == plyr_nm_color[j].plyr_id){
	                    color = plyr_nm_color[j].color;
	                    this._territory._node_list[i].data.color = color;
	                }
	            }

	            var orig_armycnt =  game_state[i].army_cnt;
	            
	            if(armies_plcd === 1 || user_id !== this._territory._node_list[i].data.owner_id)
	                $("#terr"+i).html('<p style="font-style:bold; color:'+color+';">'+this._territory._node_list[i].data.armies+'</p>');  
	            
	            else if(user_id === this._territory._node_list[i].data.owner_id){

	                 $("#terr"+i).html('<input id="armies'+i+'" type="text" size="2" value = "'+this._territory._node_list[i].data.armies+'">\
	                                    <input id="place'+i+'" type="button" value="place">\
	                                    <script type="text/javascript">\
	                                            $("#place'+i+'").ready(function(){\
	                                                    $("#place'+i+'").click(function(){\
	                                                        var added_armies = $("#armies'+i+'").val() - '+orig_armycnt+';\
	                                                        if(parseInt(added_armies) <= init_armies && parseInt($("#armies'+i+'").val()) > 0){\
	                                                            $.post("'+BASE+'/place",\
	                                                                    {armies: added_armies,\
	                                                                     uid: user_id,\
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
	}
	
}