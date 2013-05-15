
<!DOCTYPE HTML> 
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
         <title>Global Conquest</title>
        <!--CSS -->
        <?php echo Asset::styles(); ?>
        
        <!--External Libraries/etc. -->
        
        <!--My scripts-->
        <?php echo Asset::scripts(); ?>

    </head>
    <body> <!-- onload="setInterval('chat.update()', 1000)"> -->
        
        <div id="page_wrap">
            
           <div id="game_map">
                
                <div class="north_america" id="terr0" name="alaska"></div>
                <div class="north_america" id="terr1" name="alberta"></div>
                <div class="north_america" id="terr2" name="central_america"></div>
                <div class="north_america" id="terr3" name="eastern_us"></div>
                <div class="north_america" id="terr4" name="western_us"></div>
                <div class="north_america" id="terr5" name="greenland"></div>
                <div class="north_america" id="terr6" name="nw_territory"></div>
                <div class="north_america" id="terr7" name="ontario"></div>
                <div class="north_america" id="terr8" name="quebec"></div>
                <div class="south_america" id="terr9" name="argentina"></div>
                <div class="south_america" id="terr10" name="brazil"></div>
                <div class="south_america" id="terr11" name="peru"></div>
                <div class="south_america" id="terr12" name="venezuela"></div>
                <div class="europe" id="terr13" name="great_britain"></div>
                <div class="europe" id="terr14" name="iceland"></div>
                <div class="europe" id="terr15" name="northern_eur"></div>
                <div class="europe" id="terr16" name="scandinavia"></div>
                <div class="europe" id="terr17" name="southern_eur"></div>
                <div class="europe" id="terr18" name="ukraine"></div>
                <div class="europe" id="terr19" name="western_eur"></div>
                <div class="africa" id="terr20" name="congo"></div>
                <div class="africa" id="terr21" name="east_africa"></div>
                <div class="africa" id="terr22" name="egypt"></div>
                <div class="africa" id="terr23" name="madagascar"></div>
                <div class="africa" id="terr24" name="north_africa"></div>
                <div class="africa" id="terr25" name="south_africa"></div>
                <div class="asia" id="terr26" name="afghanistan"></div>
                <div class="asia" id="terr27" name="china"></div>
                <div class="asia" id="terr28" name="india"></div>
                <div class="asia" id="terr29" name="irkutsk"></div>
                <div class="asia" id="terr30" name="japan"></div>
                <div class="asia" id="terr31" name="kamchatka"></div>
                <div class="asia" id="terr32" name="middle_east"></div>
                <div class="asia" id="terr33" name="siam"></div>
                <div class="asia" id="terr34" name="siberia"></div>
                <div class="asia" id="terr35" name="ural"></div>
                <div class="asia" id="terr36" name="yakutsk"></div>
                <div class="asia" id="terr37" name="mongolia"></div>
                <div class="australia" id="terr38" name="east_australia"></div>
                <div class="australia" id="terr39" name="indonesia"></div>
                <div class="australia" id="terr40" name="new_guinea"></div>
                <div class="australia" id="terr41" name="west_australia"></div>
            </div>
            
            <table>
            <th>Global Conquest</th>
            <tr>
                <td><input id="attk_btn" type="button" value="attack"></td>
            </tr>
            <tr id="attk_mode">
                
            </tr>
            <tr>
                <td><input id="mov_btn" type="button" value="move armies"></td>
            </tr>
            <tr>
                <td><input type="button" value="cards"></td>
            </tr>
            <tr>
                <td><input type="button" value="bug report"></td>
            </tr>
            <tr>
                <td><input type="button" value="players"></td>
            </tr>
            <tr>
                <td><input type="button" value="stats"></td>
            </tr>
            <tr>
                <td><input type="button" value="rules"></td>
            </tr>
            <tr>
                <td><input type="button" value="end turn"></td>
            </tr>
            
            <tr>
                <td>
                    <div id=chat_wrap>   
                        <p id="name_area"></p>
                        <div id="chat_area"></div>
                        <form id="send_message_area">
                            <textarea id="sendie" maxlength='100'></textarea>
                        </form>
                    </div>
                </td>
            </tr>
           </table>
        </div>
    </body>
</html>






