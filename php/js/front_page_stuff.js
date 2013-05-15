$(document).ready(function(){
    
    $("#create").click(function(){
        var options = ""
        for (i=2; i<=6; i++) 
            options += "<option>"+i+"</option>";
        
        $("#setup").html('<table id="settings">\
                         <tr><td>Game Name: </td><td><input name="title" type="text"></td><tr>\
                         <tr><td>Players: </td><td><select name="num_plyrs">'+options+'</select></td>\
                         <td>Type: </td><td><select name="type"><option>Public</option><option>Private</option></select></td><tr>\
                         <tr><td><input type="submit"></tr>\
                         </table>');
    });
});