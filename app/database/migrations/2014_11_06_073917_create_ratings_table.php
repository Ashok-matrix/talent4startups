<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ratings', function(Blueprint $table)
		{
		$table->increments('id');
		$table->integer('project_id')->unsigned()->index();
		$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
		$table->integer('provider_id')->unsigned()->index();
		$table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
		$table->integer('receiver_id')->unsigned()->index();
		$table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
		$table->decimal('rating', 5, 1);
		$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ratings');
	}

}
