<?php

    class Map_Controller extends Base_Controller{
         
        public function action_index() {
           
            Asset::add('risk_style', 'css/risk_style.css');
            Asset::add('jquery', 'js/jquery20.js');
            Asset::add('chat', 'js/chat.js', 'jquery');
            Asset::add('new_chat', 'js/new_chat.js', 'jquery');
            Asset::add('graph', 'js/graph.js', 'jquery');
            Asset::add('territory_setter', 'js/territory_setter.js', 'jquery');
            Asset::add('attack', 'js/attack.js', 'jquery');
            Asset::add('move_armies', 'js/move_armies.js', 'jquery');
           
            return View::make('game_map');
        }
        
       
    }
    
?>