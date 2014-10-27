<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('episodes', function($table)
		{
      $table->increments('ep_key');
      $table->string('ep_name', 200);
      $table->text('ep_description', 400);
      $table->integer('ep_duration');
      $table->boolean('ep_explicit');
      $table->integer('ep_filesize');
      $table->string('ep_img', 200);
      $table->string('ep_link', 200);
      $table->dateTime('ep_pubdate');
      $table->string('ep_url', 200);
      $table->integer('ep_po_key');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('episodes', function(Blueprint $table)
		{
			Schema::drop('episodes');
		});
	}

}
