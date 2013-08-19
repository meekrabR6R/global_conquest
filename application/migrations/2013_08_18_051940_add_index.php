<?php

class Add_Index {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
	  Schema::table('players', function($table) {
	    $table->unique('plyr_id');
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
