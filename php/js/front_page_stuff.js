$(document).ready(function(){
    
    $("#create").click(function(){
        var options = ""
        for (i=2; i<=6; i++) 
            options += "<option>"+i+"</option>";
        
        $("#setup").html('<table id="settings">\
                         <th>Settings</th>\
                         <tr><td>Players: </td><td><select id="num_plyrs">'+options+'</select></td>\
                         <td>Type: </td><td><select id="pub_priv"><option>Public</option><option>Private</option></select></td><tr>\
                         <tr></tr>\
                         </table>');
    });
});