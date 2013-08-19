<?php

class Turn_Armies_Set {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//DB::query("alter table plyr_games add column turn_armies_set bit(1) not null default 0");
		//DB::query("alter table plyr_games modify column turn_armies_set bit(1) after trn_active");
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
