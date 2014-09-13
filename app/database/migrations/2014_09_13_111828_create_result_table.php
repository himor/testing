<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('result', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('test_id')->unsigned();
			$table->string('token', '100');

			$table->text('q_text');
			$table->string('q_image')->nullable();
			$table->text('a_text');
			$table->string('a_image')->nullable();

			$table->boolean('is_correct')->default(0);

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
		Schema::drop('result');
	}

}
