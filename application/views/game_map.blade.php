
<!DOCTYPE HTML> 
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
         <title>Global Conquest</title>
        <!--CSS -->
         <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        {{ Asset::styles(); }}
        
        <!--My scripts-->
        <script type="text/javascript">
            //Interface between PHP and Javascript variables:
            var BASE = "{{ URL::base(); }}";
            var user_id = "{{ $uid; }}";
            var user_fn = "{{ $user_fn; }}";
            var game_id = "{{ $game->game_id; }}";
            var game_table = "{{ $game_table; }}";
            var card_table = "{{ $card_table; }}";
            var plyr_limit = {{ $game->plyrs; }};
            var plyr_count = {{ $plyr_count; }};
            var armies_plcd = {{ $armies_plcd; }};
            @if(isset($game_state))
                var init_armies = {{ $init_armies; }};
            @endif
            var plyr_id = [];
            var plyr_nm_color = [];
            var plyr_fn = [];
            
            @if(isset($game_state))
                var game_state = [];
                @foreach($game_state as $state)
                    game_state.push({'terr' : 'terr'+{{ $state->id - 1; }}, 'owner_id' : '{{ $state->owner_id; }}', 'army_cnt' : {{ $state->army_cnt; }} });
                @endforeach
            @endif
        
            @foreach($plyr_data as $player)
                plyr_id.push( '{{ $player->plyr_id; }}' );
            @endforeach
            
            @foreach($plyr_fn as $player)
                plyr_fn.push( '{{ $player; }}' );
            @endforeach
            
            @if(isset($plyr_nm_color))
                @foreach($plyr_nm_color as $player)
                    @foreach($player as $x)
                        plyr_nm_color.push({'plyr_id':'{{ $x->plyr_id }}','color': '{{ $x->plyr_color; }}'});
                    @endforeach
                @endforeach
            @endif
        
        </script>
        {{ Asset::scripts(); }}
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    </head>
    <body onload="make_clicks();"> 
        <div class="container">
           
           
            <div id='content' class='row-fluid'>
                
                <div class='span2 sidebar'>
                    <h1>{{ $game->title; }}</h1>
                    @if($join_flag == 0 && ($plyr_count < $game->plyrs)) 
                        <input id="join_btn" type="button" class="btn btn-inverse" value="join">
                        <div id="color_pick2"></div>
                    @endif
                    @if($join_flag == 1 && ($plyr_count < $game->plyrs))
                      
                            <p>WAITING FOR OTHERS TO JOIN!</p>
                       
                    @endif
                    @if($armies_plcd == 0 && ($plyr_count == $game->plyrs))
                        
                            <p>WE NEED TO PLACE SOME ARMIES!!</p>
                        
                            <div id="place_armies"><p>{{ $init_armies; }} ARMIES REMANING</p></div>
                      
                    @endif
                    @if($armies_plcd == 1 && $player_up->plyr_id == $uid)
                        
                           
                        
                        <div id="attk_mode"></div>
                        
                        <input id="mov_btn" type="button" class="btn btn-inverse" value="move armies">
                        
                         <div id="mov_mode"></div>
                        
                    @endif
                    @if($armies_plcd == 1 && $player_up->plyr_id != $uid)
                       <p>WAIT IN LINE, YOUNG BLOOD.</p>
                    @endif
                   <input type="button" class="btn btn-inverse" value="cards">
                   
                        <input type="button" class="btn btn-inverse" value="players">
                        <input type="button" class="btn btn-inverse" value="bug report">
                        <input type="button" class="btn btn-inverse" value="stats">
                    
                        <input type="button" class="btn btn-inverse" value="rules">
                        <input type="button" class="btn btn-inverse" value="end turn">
                
                </div>
                <div class='span10 main'>
                    </br>
                    <div class="tabbable"> 
                        <ul class="nav nav-tabs">
                            @if($armies_plcd == 1 && $player_up->plyr_id == $uid)
                                <li id="attk_btn" class="active"><a href="#tab1" data-toggle="tab">attack</a></li>
                                <li><a href="#tab2" data-toggle="tab">move armies</a></li>
                            @endif
                            <li><a href="#tab3" data-toggle="tab">cards</a></li>
                            <li><a href="#tab4" data-toggle="tab">players</a></li>
                            <li><a href="#tab5" data-toggle="tab">end turn</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <p>I'm in Section 1.</p>
                            </div>
                            <div class="tab-pane" id="tab2">
                                <p>Howdy, I'm in Section 2.</p>
                            </div>
                            <div class="tab-pane" id="tab3">
                                <p>Howdy, I'm in Section 3.</p>
                            </div>
                            <div class="tab-pane" id="tab4">
                                <p>Howdy, I'm in Section 4.</p>
                            </div>
                            <div class="tab-pane" id="tab5">
                                <p>Howdy, I'm in Section 5.</p>
                            </div>
                        </div>
                    </div>

                    <img id="game_map" src="{{ URL::base(); }}/images/map.jpg">
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
            </div>
    
    </body>
</html>






