<?php
    
    $raw_date = getdate();
    $date = $raw_date['year']."-".$raw_date['mon']."-".$raw_date['mday'];
        
    $mysqli = new mysqli('localhost', 'root', null, 'global_conq');
    
    if (mysqli_connect_error()) 
             die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    
    if($_POST){        
        if($_POST['funct'] == 'new_game'){
            $new_game = $_POST['data']; 
            $add_game = array();
                                                                   
            foreach($new_game as $x)
                $add_game[] = $x['value'];
             
                
            $mysqli->query("insert into games  set title = '".$add_game[0]."', plyrs = ".$add_game[1].", type = '".$add_game[2]."',
                        maker_id = (select plyr_id from players where plyr_id = '".$add_game[3]."'), start_date = '".$date."'");
            
        }
        
        else if($_POST['funct'] == 'new_player'){
            $mysqli->query("insert into players (plyr_id, first_name, last_name, start_date) values('".$_POST['id']."','".$_POST['fn']."','".$_POST['ln']."','".$date."')");
        }
       
    }
    else if($_GET['funct'] == 'get'){
        $result = $mysqli->query("select * from games");//finetune this
        var_dump($result->fetch_all());
    }
    $mysqli->close();
?>