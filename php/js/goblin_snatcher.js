var Game = {

    hero : { 
        speed : 256,
        x : 0,
        y : 0,
    },

    monster : { 
        speed : 512,
        x : 0,
        y : 0,
    },
    
    keysDown : {},
    bgImage : new Image(),
    heroImage : new Image(),
    monsterImage : new Image(),

    backgroundReady : false,
    heroReady : false,
    monsterReady : false,

    monstersCaught : 0,
    monstersLost : 0,
    
	loadImage : function(sprite, ready, src) {

        sprite.onload = function() {
        	ready = true;
        };

        sprite.src = src;
	},
    
    inputControl : function() {

    	addEventListener("keydown", function(e) {
    		Game.keysDown[e.keyCode] = true;
    	}, false);

    	addEventListener("keyup", function(e) {
    		delete Game.keysDown[e.keyCode];
    	}, false);
    },

    set : function(canvas) {

		Game.hero.x = canvas.width / 2;
		Game.hero.y = canvas.height / 2;

		Game.monster.x = 32 + (Math.random() * (canvas.width - 64));
		Game.monster.y = 32 + (Math.random() * (canvas.height - 64)); 
    	
    },

    reset : function(canvas, heroX, heroY) {

        Game.hero.x = heroX;
        Game.hero.y = heroY;

        Game.monster.x = 32 + (Math.random() * (canvas.width - 64));
        Game.monster.y = 32 + (Math.random() * (canvas.height - 64)); 
        
    },

    update : function(heroModifier, monsterModifier, canvas, snd) {
        
        Game.monster.x += Game.monster.speed * monsterModifier;
       
    	if(87 in Game.keysDown)
    		Game.hero.y -= Game.hero.speed * heroModifier;

    	if(83 in Game.keysDown)
    		Game.hero.y += Game.hero.speed * heroModifier;

    	if(65 in Game.keysDown)
    		Game.hero.x -= Game.hero.speed * heroModifier;

    	if(68 in Game.keysDown)
    		Game.hero.x += Game.hero.speed * heroModifier;

    	if( Game.hero.x <= (Game.monster.x + 32) &&
    		Game.monster.x <= (Game.hero.x + 32) && 
    	    Game.hero.y <= (Game.monster.y + 32) && 
    	    Game.monster.y <= (Game.hero.y + 32)) {
            
            snd.play();
            ++Game.monstersCaught;
            Game.reset(canvas, Game.hero.x, Game.hero.y);
        }

        if( Game.monster.x + 32 >= 512) {
            Game.reset(canvas, Game.hero.x, Game.hero.y);
            ++Game.monstersLost;
        }
    },
    
    render : function(canvas) {
    	var context = canvas.getContext("2d");
    	Game.backgroundReady = true;
    	Game.heroReady = true;
    	Game.monsterReady = true;
    	if(Game.backgroundReady)
    		context.drawImage(Game.bgImage, 0, 0);

        if(Game.heroReady)
        	context.drawImage(Game.heroImage, Game.hero.x, Game.hero.y);

        if(Game.monsterReady)
        	context.drawImage(Game.monsterImage, Game.monster.x, Game.monster.y);
        
        context.fillStyle = "rgb(250, 250, 250)";
        context.font = "24px Helvetica";
        context.textAlign = "left";
        context.textBaseline = "top";
        context.fillText("Goblins caught: " + Game.monstersCaught, 32, 32);
        context.fillText("Goblins lost: " + Game.monstersLost, 332, 32);
    },

    main: function() {
    	var canvas = document.getElementById('game_map');
        var snd = new Audio("audio/hit.wav"); // buffers automatically when created

	    Game.loadImage(Game.bgImage, Game.backgroundReady, 'images/background.png');
        Game.loadImage(Game.heroImage, Game.heroReady, 'images/hero.png');
        Game.loadImage(Game.monsterImage, Game.monsterReady, 'images/monster.png');
	   
	    Game.render(canvas);
	    Game.inputControl();
	    
        Game.set(canvas);
	   
        var then = Date.now();
	    setInterval(function() {
    	    var now = Date.now();
    	    var delta = now - then;

    	    Game.update(delta / 1000, delta / 7000, canvas, snd);
    	    Game.render(canvas);
            then = now;
        }, 1);
	},
};

$(document).ready(function(){ Game.main(); }); 
