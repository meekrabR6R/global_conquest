
/***********************************
* Move armies namespace
***********************************/
var MoveArmies = {

    /***********************************
    * GameSpace object
    ***********************************/
    game: GameSpace,
    /***********************************
    * Sets 'move army' clicks
    ************************************/
    makeMove: function(){

        $("#mov_btn").ready(function(){

            $("#mov_btn").click(function(){

               MoveArmies.setClicks();
            });
        });
    },

    /************************************
    * Makes the nodes in each continent
    * clickable.
    ************************************/
    setClicks: function(){

        MoveArmies.moveClick(".north_america");
        MoveArmies.moveClick(".south_america");
        MoveArmies.moveClick(".europe");
        MoveArmies.moveClick(".africa");
        MoveArmies.moveClick(".asia");
        MoveArmies.moveClick(".australia");
    },

    /**********************************
    * Sets up clicks
    ***********************************/
    moveClick: function(continent){

       $(continent).each(function(){

            var node = MoveArmies.game.graph.get_node($(this).attr('name'));

            if(node.data.owner_id === MoveArmies.game.user_id){

                $(this).click(function(){

                    border_list = [];
                    $("#select_text").text('From: ' + node.id);

                    node.edges.forEach(function(border){
                        var border_node = MoveArmies.game.graph.get_node(border);

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

                        $("#select_to").html(country_select + '<input id="mov_armies" type="button" class="btn btn-inverse" value="move" onclick="MoveArmies.moveArmies();">');

                    }
                    else{
                        $("#select_from").html('<p>PLEASE SELECT A TERRITORY WITH MORE THAN 1 ARMY.</p>');
                    }

                });

            }

        });
    },

    /*******************************************
    * Posts 'from' and 'to' territory ids, as well
    * as army amount.
    * @param fromID - ID of territory from which
    * armies are being moved
    *********************************************/
    moveArmies: function (){

        var toTerr = MoveArmies.game.graph.get_node($('#movable').find(":selected").text());
        var toID = toTerr.data.pk_id;

        var fromName = $.trim($('#select_text').text().split(':')[1]);

        var fromTerr = MoveArmies.game.graph.get_node(fromName);
        var fromID = fromTerr.data.pk_id;

        var textAmount = $("#place_amount").find(":selected").text();
         //Safari 'fix'
        if($("#place_amount").find(":last").text()+''+$("#place_amount").find(":last").text() === $("#place_amount").find(":selected").text()){
            textAmount = $("#place_amount").find(":last").text();
            alert(textAmount);
        }

        var amount = parseInt(textAmount, 10);

        var fromAmount = fromTerr.data.armies - amount;
        var toAmount = toTerr.data.armies + amount;

        $("div[name="+fromTerr.id+"]").html('<p style="color:'+fromTerr.data.color+';">'+fromAmount+'</p>');
        $("div[name="+toTerr.id+"]").html('<p style="color:'+toTerr.data.color+';">'+toAmount+'</p>');

        $('#roll').attr("disabled", true); //change to end turn

        $.post(MoveArmies.game.BASE+'/move_armies?game_id='+MoveArmies.game.game_id,
                {game_table: MoveArmies.game.game_table,
                 game_id: MoveArmies.game.game_id,
                 user_id: MoveArmies.game.user_id,
                 from_id: fromID,
                 to_id: toID,
                 from_amount: fromAmount,
                 to_amount: toAmount},
                function(result){
                    $("#mov_armies").attr('disabled', true);
                    location.reload();
                }
        );


    }   
}

MoveArmies.makeMove();

/**************************************
* Ends turn
***************************************/
$("#end").ready(function(){

    $("#end").click(function(){
      
        $.post(MoveArmies.game.BASE+'/end_turn?game_id='+MoveArmies.game.game_id,
                {user_id: MoveArmies.game.user_id,
                 game_id: MoveArmies.game.game_id},
                 function(result){
                    location.reload();
                 }
        );
    });
});