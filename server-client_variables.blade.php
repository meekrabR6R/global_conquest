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