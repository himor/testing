<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('question', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('test_id')->unsigned();
			$table->integer('type')->default(0);
			$table->text('text');
			$table->string('image')->nullable();

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
		Schema::drop('question');
	}

}
