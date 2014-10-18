<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePodcastsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('podcasts', function($table)
		{
      $table->increments('po_key');
      $table->string('po_name', 100);
      $table->string('po_feed', 400);
      $table->string('po_feeddev', 100);
      $table->string('po_url', 200);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('podcasts', function(Blueprint $table)
		{
			Schema::drop('podcasts');
		});
	}

}
