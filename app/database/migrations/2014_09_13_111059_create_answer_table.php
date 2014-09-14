<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('answer', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('question_id')->unsigned();
			$table->text('text');
			$table->string('image', '255')->nullable();
			$table->integer('weight')->default(0);
			$table->boolean('is_correct')->default(0);

			$table->timestamps();

			$table->foreign('question_id')->references('id')->on('question');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('answer');
	}

}
