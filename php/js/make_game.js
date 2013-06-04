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
             $.post(BASE+'/join',
                   {uid: uid,
                    game_id: game_id,
                    plyr_color: color},
                   function(result){
                        console.log(result);
              });
          });
    });

  });

});  
