

/*********************************
* Form validation for new games
**********************************/
function checkForm(newGame){

    var element = document.getElementById('error');

    if(newGame.title.value === ""){
        element.className += ' ' + 'error';

        $('#error_text').text('Game title cannot be blank.');
    }
    else{
        var form_data = $("#new_game").serializeArray();

        if(element.className === 'control-group error'){
            element.className = 'control-group success';
            $('#error_text').text("Isn't that better?");
        }

        $('#game_made').text("Game made!");

         $.post(BASE+'/new_game',
               {data: form_data},
                function(result){
                   location.reload();
               }
        );
    }

    return false;
}

$(document).ready(function(){

    $("#create").click(function(){

        var options = "";
        for (i=2; i<=6; i++)
            options += "<option>"+i+"</option>";
    });
});

function add_player() {
    $.post(BASE,
        {id: user_id,
         fn: user_fn,
         ln: user_ln},
        function(result){
            console.log(result);
        }
    );
}

function get_games() {
    $.get(BASE+'/games',
        function(result){
            console.log(result);
        }
    );
}