$(document).ready(function(){
    
    $("#create").click(function(){
     
        var options = ""
        for (i=2; i<=6; i++) 
            options += "<option>"+i+"</option>";
        
        $("#setup").html('<form id="new_game" action="../application/models/games.php" method="post" onsubmit="return false;">\
                            <table id="settings">\
                            <tr><td>Game Name: </td><td><input name="title" type="text"></td><tr>\
                            <tr><td>Players: </td><td><select name="num_plyrs">'+options+'</select></td>\
                            <td>Type: </td><td><select name="type"><option>Public</option><option>Private</option></select></td><tr>\
                            <input name="maker_id" type="hidden" value="'+user_id+'">\
                            <tr><td><input id="game_submit" type="submit" value="make game"></tr>\
                            </table></form>');
        
        $("#game_submit").ready(function(){
    
            $("#game_submit").click(function(){
             
                var form_data = $("#new_game").serializeArray();
                
                $.post(BASE+'/db',
                       {funct: 'new_game',
                        data: form_data},
                        function(result){
                           console.log(result);
                           $("#setup").append('<input id="add_plyrs" type="button" value="add players">');
                       }
                );
            });
            
            
            $("#add_plyrs").click(function(){
            
            });
    
        });
    
    
    });
    
    
    
});

function add_player() {
    
    $.post(BASE+'/db',
        {funct: 'new_player',
         id: user_id,
         fn: user_fn,
         ln: user_ln},
        function(result){
            console.log(result);
        }
    );
    
}

function get_games() {
    
    $.get(BASE+'/db',
          {funct: "get"},
        function(result){
            console.log(result);
        }
    );
}