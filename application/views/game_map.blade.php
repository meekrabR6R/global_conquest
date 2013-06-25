
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
            var game_id = "{{ $game_id; }}";
            var game_table = "{{ $game_table; }}";
            var card_table = "{{ $card_table; }}";
            var plyr_limit = {{ $plyr_limit; }};
            var plyr_count = {{ $plyr_count; }};
            var armies_plcd = {{ json_encode($armies_plcd); }};
          
            var upPlayer = '';
            @if(isset($player_up))           
                var upPlayer = {{ $player_up->plyr_id; }};
            @endif
            @if(isset($game_state) && $init_armies != null)
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

           
            @if(isset($player_cards))
                var plyr_cards = [];
                @foreach($player_cards as $card)

                    plyr_cards.push({'army_type' : '{{ $card['army_type']; }}', 'terr_name' : '{{ $card['terr_name']; }}' });
                @endforeach
                console.log(plyr_cards);
            @endif
        
        </script>
        
        {{ Asset::scripts(); }}
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

    </head>
    <body onload="make_clicks();"> 
        <div class="container">
           
           
            <div id='content' class='row-fluid'>
                
                <div class='span2 sidebar'>
                    <h1>{{ $game_title; }}</h1>
                    @if($join_flag == 0 && ($plyr_count < $plyr_limit)) 
                        <input id="join_btn" type="button" class="btn btn-inverse" value="join">
                        <div id="color_pick2"></div>
                    @endif
                    @if($join_flag == 1 && ($plyr_count < $plyr_limit))
                      
                            <p>WAITING FOR OTHERS TO JOIN!</p>
                       
                    @endif
                    @if($armies_plcd == false && ($plyr_count == $plyr_limit) || isset($player_up->plyr_id) == $uid)
                        <div class="hero-unit">
                            <p>WE NEED TO PLACE SOME ARMIES!!</p>
                        
                            <div id="place_armies"><p>{{ $init_armies; }} ARMIES REMANING</p></div>
                        </div>
                    @endif

            
                    @if(isset($player_up->plyr_id)!= $uid)
                        <div class="hero-unit">
                             <h5>WAIT IN LINE, YOUNG BLOOD.</h5>
                        </div>
                    @endif

                    <input type="button" class="btn btn-inverse" value="bug report">
                    <input type="button" class="btn btn-inverse" value="stats">
                    <input type="button" class="btn btn-inverse" value="rules">
                </div>
                <div class='span10 main'>
                    </br>
                    <div class="tabbable"> 
                        <ul class="nav nav-tabs">

                            @if($armies_plcd == true && $player_up->plyr_id == $uid)
                                <li class="active"><a href="#tab1" data-toggle="tab">attack</a></li>
                                <li id="mov_btn"><a href="#tab2" data-toggle="tab">move armies</a></li>
                            @endif

                            <li><a href="#tab3" data-toggle="tab">cards</a></li>
                            <li><a href="#tab4" data-toggle="tab">players</a></li>

                            @if($armies_plcd == true && $player_up->plyr_id == $uid)
                                <li><a href="#tab5" data-toggle="tab">end turn</a></li>
                            @endif

                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">

                                <div class="row">
                                    <div class="span1"></div>
                                    <div class="span5" id="select"></div>
                                    <div class="span2">

                                        @if($armies_plcd == true && $player_up->plyr_id == $uid)
                                            <p id="attack">Click one of your countries to begin attacking.</p>
                                        @endif

                                    </div>
                                    <div class="span2" id="defend"></div>
                                </div>

                            </div>
                            <div class="tab-pane" id="tab2">
                                <div class="row">
                                    <div class="span1"></div>
                                    <div class="span1">
                                        <div id="select_text">SELECT COUNTRY</div>
                                    </div>
                                    <div class="span4">
                                        <div id="select_from"></div>
                                    </div>
                                    <div class="span4">
                                        <div id="select_to"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab3">
                                <div class="row" id="cards">
                                    <div class="span1"></div>

                                    <form id="cards_check" action="{{ URL::base() }}/card_turn_in" method="post" onsubmit="return checkCards(this);">

                                        @if(isset($player_cards))
                                            @foreach($player_cards as $card)
                                                <div class="card span2">
                                                    <h6>{{ $card['army_type'] }}</h6></br>
                                                    </br>
                                                    <h7>{{ $card['terr_name'] }}</h7>
                                                    <input type="checkbox" name="{{ $card['terr_name']; }}" value="{ 'army_type' : '{{ $card['army_type']; }}', 'terr_name' : '{{ $card['terr_name']; }}' }">
                                                </div>
                                            @endforeach
                                        @endif

                                        <div class="span1">
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
                    <div class="europe" id="terr19" name="Western Europe"></div>
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






