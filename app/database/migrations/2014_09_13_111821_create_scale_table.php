<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScaleTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('scale', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('test_id')->unsigned();
			$table->integer('from')->default(0);
			$table->integer('to')->default(0);
			$table->string('text', '255');
			$table->text('description');

			$table->timestamps();

			$table->foreign('test_id')->references('id')->on('test');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('scale');
	}

}
