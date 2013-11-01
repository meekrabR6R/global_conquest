
/********************************
* Place Armies namespace
*********************************/
var PlaceArmies = {

    /***********************************
    * GameSpace object
    ***********************************/
    game: GameSpace,
    /***********************************
    * Sets 'place army' clicks
    ************************************/
    makePlace: function(){

        $("#place_btn").ready(function(){

            PlaceArmies.createClicks();
        });
    },


    /*******************************************
    * Posts placed armies
    *********************************************/
    placeArmies: function (placeName){

        $("#mov_armies").attr('disabled', true);
        var placeTerr = PlaceArmies.game.graph.get_node(placeName);
        var placeID = placeTerr.data.pk_id;

        //needs to get terr amount from server
        var textAmount = $("#place_amount").find(":selected").text();
     
        //Safari 'fix'
        if($("#place_amount").find(":last").text()+''+$("#place_amount").find(":last").text() === $("#place_amount").find(":selected").text()){
            textAmount = $("#place_amount").find(":last").text();
        }

        var amount = parseInt(textAmount, 10);

        placeTerr.data.armies += amount;

        $("div[name="+placeTerr.id+"]").html('<h3 style="color:'+placeTerr.data.color+';">'+placeTerr.data.armies+'</h3>');

        $.post(PlaceArmies.game.BASE+'/place?game_id='+PlaceArmies.game.game_id,
                 {armies: amount,
                  uid: PlaceArmies.game.user_id,
                  game_id: PlaceArmies.game.game_id,
                  terr_num: placeTerr.data.pk_id-1,
                  game_table: PlaceArmies.game.game_table},

                  function(result){
                    $("#place_armies").html("<p>"+result+" ARMIES REMANING</p>");
                    PlaceArmies.game.init_armies = result;
                    PlaceArmies.setAmount(placeTerr, result);
                    init_armies = result;
                    if(result == 0){
                        $("#mov_armies").attr('disabled', true);
                        $.get(PlaceArmies.game.BASE+'/map?game_id='+PlaceArmies.game.game_id,
                              function(r) {
                                 location.reload();
                              }
                        );
                       
                    }
                    else
                        $("#mov_armies").removeAttr('disabled');
                  }
        );


    },

    /*********************************************
    * Add placed armies to terr army count and
    * updates place army select drop.
    **********************************************/
    setAmount: function(territoryNode, armyAmount){

        var armies = "";

        for(i=1; i <= armyAmount; i++){
            if(i === 1)
                armies += '<option id="'+i+'" selected>'+i+'</option>';
            else
                armies += '<option id="'+i+'">'+i+'</option>';
        }

        var newAmount = territoryNode.data.armies + armies;
        $("#place").html('<select id="place_amount">'+armies+'</select>&nbsp;<input id="mov_armies" type="button" class="btn btn-inverse" value="place" onclick="PlaceArmies.placeArmies(\''+territoryNode.id+'\');"> in '+territoryNode.id);
    },

    /*******************************
    * Makes terrs clickable for
    * army placement
    ********************************/
    placeClicks: function(continent){

       $(continent).each(function(){

            var node = PlaceArmies.game.graph.get_node($(this).attr('name'));

            if(node.data.owner_id === PlaceArmies.game.user_id && PlaceArmies.game.init_armies > 0){

                $(this).click(function(){
                    PlaceArmies.setAmount(node, PlaceArmies.game.init_armies);
                });

            }

        });

    },

    /****************************
    * Makes territories PlaceArmies.unClickable
    * with regard to placement.
    *******************************/
    unClick: function(continent){
        $(continent).each(function(){
                   
            var node = PlaceArmies.game.graph.get_node($(this).attr('name'));
          
            if(node.data.owner_id === PlaceArmies.game.user_id){   
                 $(this).attr("disabled", true);
            }
        });

    },

    /**********************
    * see above ;)
    **********************/
    unDoClick: function(){

        PlaceArmies.unClick(".north_america");
        PlaceArmies.unClick(".south_america");
        PlaceArmies.unClick(".europe");
        PlaceArmies.unClick(".africa");
        PlaceArmies.unClick(".asia");
        PlaceArmies.unClick(".australia");
    },

    /************************************
    * Makes the nodes in each continent
    * clickable.
    ************************************/
    createClicks: function(){

        PlaceArmies.placeClicks(".north_america");
        PlaceArmies.placeClicks(".south_america");
        PlaceArmies.placeClicks(".europe");
        PlaceArmies.placeClicks(".africa");
        PlaceArmies.placeClicks(".asia");
        PlaceArmies.placeClicks(".australia");
    }
}

PlaceArmies.makePlace();