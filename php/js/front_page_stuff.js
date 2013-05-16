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
                            <tr><td><input id="game_submit" type="submit" value="make game"></tr>\
                            </table></form>');
        
        $("#game_submit").ready(function(){
    
            $("#game_submit").click(function(){
               
                var form_data = $("#new_game").serialize();
                
                $.post("../application/models/games.php",
                       {data: form_data},
                       function(result){
                            alert(result);
                       }
                );
            });
    
        });
    
    
    });
    
    
    
});

