$(document).ready(function(){
   
   $("#join_btn").click(function(){
        $.post(BASE+'/db',
               {funct: 'join',
                uid: uid,
                game_id: game_id},
               function(result){
                    console.log(result);
               }
        );
   });
    
});