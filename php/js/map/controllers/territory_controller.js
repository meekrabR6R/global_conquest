/**************************************
* Territory Controller
***************************************/

//Constructor
function TerritoryController(territory, mapView, gameTable){
	this._territory = territory;
	this._map = mapView;
	this._gameTable = gameTable;
}

TerritoryController.prototype = {

	//adds nodes to this._territory of territories
	addNodes: function(){

		for(i=0; i <= 41; i++){ //upper-bound of for-loop should be replaced with length of list/array/whatever pulled from server
        
	        var name = $("#terr"+i).attr('name'); //this data should come from the server (maybe a territory table?)
	        $("#terr"+i).append('<p>'+name+'</p>');
	        this._territory.add_node(name); 
        }
    
	},

	
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
	},

	//prompts victorious attacker to move armies
	victoryPrompt: function(attk_terr, def_terr, attk_armies){

		$("#roll").attr("disabled", true);
        def_terr.data.owner_name = attk_terr.data.owner_name;
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
        def_terr.data.owner_id = attk_terr.data.owner_id;
        def_terr.data.color = attk_terr.data.color;

        $.get(BASE+'/card_status',
            {owner_id: attk_terr.data.owner_id,
            game_id: game_id},
            function(result){
                    
                var res = JSON.parse(result); 
                if(res.got_card == 0){
                    console.log(res.got_card);
                    makeCard(res.owner_id, game_id );
                }
            }
        );

        $.post(BASE+'/take_over',
               {game_table: this._gameTable,
                attk_id: attk_terr.data.pk_id,
                def_id: def_terr.data.pk_id,
                attacker_id: attk_terr.data.owner_id,
                attk_armies: attk_terr.data.armies,
                def_armies: def_terr.data.armies},
                function(result){
                    console.log(result);
                }
        );

        set_clicks();

	},

	postAttack: function(){

		var result = this._territory.attack;

		$("#result").val(result.attResult + " /// " + result.defResult);

	    $.post(BASE+'/attack',
	           {game_table: this._gameTable,
	            attk_armies: result.attkArmies,
	            def_armies: result.defArmies,
	            attk_id: result.attkPK,
	            def_id: result.defPK},
	            function(data){
	                console.log(data);
	            }
	    )
	},

	//updates army count/color in view
	battleDisplay: function(attk_terr, def_terr){

	    if(attk_terr.data.owner_id === user_id){
	        $("div[name="+attk_terr.id+"]").html('<p style="color:'+attk_terr.data.color+';">'+attk_terr.data.armies+'</p>');
	        $("div[name="+def_terr.id+"]").html('<p style="color:'+def_terr.data.color+';">'+def_terr.data.armies+'</p>');
	    }
	},

	//makes territories clickable by continent
	makeClickable: function(continent){
     
       $(continent).each(function(){
            
            var node = this._territory.get_node($(this).attr('name'));
          
            if(node.data.owner_id === user_id){   
               
                $(this).click(function(){
        
                    border_list = [];
                    $("#attack").text(node.id);
                    
                    node.edges.forEach(function(border){
                        var border_node = this._territory.get_node(border); 
                        
                        if(border_node.data.owner_id !== node.data.owner_id) 
                            border_list.push(border);
                                
                    });
                    
                    if(node.data.armies > 1) {
                      
                        var dice_options = "";
                        var attk_count;

                        if(node.data.armies > 3)
                            attk_count = 3;
                        else if(node.data.armies == 3)
                            attk_count = 2;
                        else
                            attk_count = 1;
                        
                        for(i=1; i <= attk_count; i++){
                            dice_options += '<option id="'+i+'">'+i+'</option>';
                           
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
            
            }
                
        });
        
	},

	//connects nodes in this._territory
	connectTerritories: function(){

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
	
}