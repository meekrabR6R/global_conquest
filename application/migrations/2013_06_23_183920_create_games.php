<?php

class Create_Games {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('games', function($table) {
		// auto incremental id (PK)
			$table->increments('game_id');
			
			$table->integer('plyrs');
			$table->string('type', 20);
			$table->string('maker_id', 20);
			$table->boolean('active')->default(0);
			$table->boolean('turns_set')->default(0);
			$table->integer('turn_ins')->default(0);
			// created_at | updated_at DATETIME
			$table->timestamps();
		});

		Schema::create('plyr_games', function($table) {
		// auto incremental id (PK)
			$table->increments('plyr_games_id');
			
			$table->string('plyr_id', 20);
			$table->string('game_id', 20);
			$table->string('plyr_color', 20);
			$table->integer('turn');
			$table->boolean('turn_active')->default(0);
			$table->boolean('got_card')->default(0);
			$table->integer('init_armies');
			// created_at | updated_at DATETIME
			$table->timestamps();

			$table->foreign('plyr_id')->references('plyr_id')->on('players');
			$table->foreign('game_id')->references('game_id')->on('games');
		});
			
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}