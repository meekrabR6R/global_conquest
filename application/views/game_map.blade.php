
<!DOCTYPE HTML> 
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

         <title>Global Conquest</title>
        <!--CSS -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        {{ Asset::styles(); }}
        
        <!--My scripts-->
        <script type="text/javascript">
            //Interface between PHP and Javascript variables:
            var GameSpace = {
                BASE : "{{ URL::base(); }}",
                user_id : "{{ $uid; }}",
                user_fn : "{{ $user_fn; }}",
                game_id : "{{ $game_id; }}",
                game_table : "{{ $game_table; }}",
                card_table : "{{ $card_table; }}",
                plyr_limit : {{ $plyr_limit; }},
                plyr_count : {{ $plyr_count; }},
                armies_plcd : {{ json_encode($armies_plcd); }},
                join_flag : '{{ $join_flag }}',
                upPlayer : '',
                plyr_id : [],
                plyr_nm_color : [],
                plyr_fn : [],
                game_state : [],
                plyr_cards : []
            };
         
            @if(isset($player_up))           
                GameSpace.upPlayer = {{ $player_up->plyr_id; }};
                GameSpace.terrUnTaken = "{{ $temp_take_over['beat_terr']; }}";
                GameSpace.attkHold = "{{ $temp_take_over['attk_terr']; }}";
                GameSpace.defHold = "{{ $temp_take_over['def_terr']; }}";
                GameSpace.armiesHold = "{{ $temp_take_over['attk_armies']; }}";
                GameSpace.turnArmiesSet = "{{ $player_up->turn_armies_set; }}";
            @else
                GameSpace.terrUnTaken = "";
            @endif

            
            @if(isset($game_state) && $init_armies !== null)
                GameSpace.init_armies = parseInt({{ $init_armies; }}, 10);
            @endif
            
            @if(isset($game_state))
                @foreach($game_state as $state)
                    GameSpace.game_state.push({'terr' : 'terr'+{{ $state->id - 1; }}, 'owner_id' : '{{ $state->owner_id; }}', 'army_cnt' : {{ $state->army_cnt; }} });
                @endforeach
            @endif
        
            @foreach($plyr_data as $player)
                GameSpace.plyr_id.push( '{{ $player["player"]->getPlyrID(); }}' );
            @endforeach
            
            @foreach($plyr_fn as $player)
                GameSpace.plyr_fn.push( '{{ $player; }}' );
            @endforeach
            
            @if(isset($plyr_nm_color))
                @foreach($plyr_nm_color as $player)
                    GameSpace.plyr_nm_color.push({'plyr_id':'{{ $player['plyr_id'] }}','color': '{{ $player['plyr_color']; }}'});
                @endforeach
            @endif

            @if(isset($player_cards))
                
                @foreach($player_cards as $card)
                    GameSpace.plyr_cards.push({'army_type' : '{{ $card['army_type']; }}', 'terr_name' : '{{ $card['terr_name']; }}' });
                @endforeach
            @endif
        
        </script>
        
        {{ Asset::scripts(); }}
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    </head>
    <body onload="Attack.makeAttack();"> 
        <div class="container">
           
           
            <div id='content' class='row-fluid'>
                
                <div class='col-lg-2 sidebar'>
                    <h1>{{ $game_title; }}</h1>

                     @if($winner)
                        <div class="hero-unit">
                            <h5>{{ $winner_name }} is victorious!</h5>
                        </div>
                    @else

                        @if($join_flag == 0 && ($plyr_count < $plyr_limit)) 
                            <input id="join_btn" type="button" class="btn btn-inverse" value="join">
                            <div id="color_pick2"></div>
                        @endif

                        @if($join_flag == 1 && ($plyr_count < $plyr_limit))
                            <div class="hero-unit">
                                <h5>WAITING FOR OTHERS TO JOIN!</h5>
                            </div>
                        @endif

                        @if($join_flag == 1 && !$plyr_data[0]["color"]) 
                            <div id="color_pick2"></div>
                            <script type="text/javascript">
                                GameSpace.colorSelect();
                            </script>
                        @endif

                        @if($init_armies_placed == false && ($plyr_count == $plyr_limit) && $plyr_data[0]["color"]) 
                            <div class="hero-unit">
                                <h5>INITIAL ARMY PLACEMENTS:</h5>
                            
                                <div id="place_armies"><h5>{{ $init_armies; }} ARMIES REMANING</h5></div>
                            </div>
                        @endif

                        @if(isset($player_up->plyr_id) && $player_up->plyr_id == $uid && $init_armies > 0 && $init_armies_placed == true)
                            <div class="hero-unit">
                                <h5>PLACE ARMIES: </h5>
                            
                                <div id="place_armies"><h5>{{ $init_armies; }} ARMIES REMANING</h5></div>
                            </div>
                        @endif

                        @if(isset($player_up->plyr_id) && $init_armies_placed == true)
                            @if($player_up->plyr_id != $uid)
                                <div class="hero-unit">
                                     <h5>WAIT IN LINE, YOUNG BLOOD.</h5></br>
                                     <h5>{{ $player_up->first_name }} is pwning the world.</h5>
                                </div>
                            @endif
                        @endif
                    @endif
                </div>
                <div class='col-lg-10 main'>
                    </br>
                    <div class="tabbable"> 
                        <ul class="nav nav-tabs">

                            @if(!$winner)
                                @if(sizeof($player_cards) < 6)
                                    @if($armies_plcd == true && $player_up->plyr_id == $uid)
                                        <li class="active"><a href="#tab1" data-toggle="tab">attack</a></li>
                                        <li id="mov_btn"><a href="#tab2" data-toggle="tab">move armies</a></li>
                                    @else
                                        <li id="place_btn" class="active"><a href="#tab1" data-toggle="tab">place armies</a></li>
                                    @endif
                                @endif
                            @endif

                            @if(sizeof($player_cards) == 6)
                                <li class="active"><a href="#tab3" data-toggle="tab">cards</a></li>
                            @else
                                <li><a href="#tab3" data-toggle="tab">cards</a></li>
                            @endif

                            <li><a href="#tab4" data-toggle="tab">players</a></li>

                            @if($armies_plcd == true && $player_up->plyr_id == $uid)
                                <li><a href="#tab5" data-toggle="tab">end turn</a></li>
                            @endif

                        </ul>
                        <div class="tab-content">
                           
                            @if(sizeof($player_cards) < 6)
                                <div class="tab-pane active" id="tab1">
                            @else
                                <div class="tab-pane" id="tab1">
                            @endif

                                <div class="row">
                                    <div class="col-lg-1"></div>
                                        
                                       
                                        @if($armies_plcd == true && $player_up->plyr_id == $uid)
                                            <div class="col-lg-5" id="select"></div>
                                            <div class="col-lg-2">
                                                <p id="attack">Click one of your countries to begin attacking.</p>
                                        @else
                                                <div class="col-lg-7">
                                                    <p id="place">Click one of your countries to place armies.</p>
                                        @endif
                                     

                                    </div>
                                    <div class="col-lg-2" id="defend"></div>
                                </div>

                            </div>
                            <div class="tab-pane" id="tab2">
                                <div class="row">
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-1">
                                        <div id="select_text">SELECT COUNTRY</div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div id="select_from"></div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div id="select_to"></div>
                                    </div>
                                </div>
                            </div>

                            @if(sizeof($player_cards) == 6)
                                <div class="tab-pane active" id="tab3">
                            @else
                                <div class="tab-pane" id="tab3">
                            @endif

                                <div class="row" id="cards">
                                    <div class="col-lg-1"></div>

                                    <form id="cards_check" action="{{ URL::base() }}/card_turn_in" method="post" onsubmit="return Attack.checkCards(this);">

                                        @if(isset($player_cards))
                                            @foreach($player_cards as $card)
                                                <div class="card col-lg-2">
                                                    <h6>{{ $card['army_type'] }}</h6></br>
                                                    </br>
                                                    <h7>{{ $card['terr_name'] }}</h7>
                                                    <input type="checkbox" name="{{ $card['terr_name']; }}" value="{{ $card['army_type']; }}">
                                                </div>
                                            @endforeach
                                        @endif

                                        <div class="col-lg-1">
                                             <button type="submit" class="btn btn-primary">Turn In</button>
                                        </div>
                                    </form>

                                </div>
                            </br>
                            </div>
                            <div class="tab-pane" id="tab4">
                                <p>Howdy, I'm in Section 4.</p>
                            </div>
                            <div class="tab-pane" id="tab5">
                                 <input id="end" type="button" class="btn btn-inverse" value="end turn">
                            </div>
                        </div>
                    </div>

                    <div id="image" class="img-responsive">
                        <img id="game_map" class="img-responsive" src="{{ URL::base(); }}/images/map.jpg">
                    
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
                        <div class="europe" id="terr19" name="western_europe"></div>
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
            </div>
            
            <!-- Modal -->
            <div id="take_over" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <h3 id="myModalLabel">How many armies would you like to move?</h3>
                </div>
                <div class="modal-body">
                   <p>Armies </p><div id="takeover_select"></div>
                </div>
                <div class="modal-footer">
                    <button id="occupy" class="btn btn-primary">Move armies</button>
                </div>
            </div>

    </body>
</html>






