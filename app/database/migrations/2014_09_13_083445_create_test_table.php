<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('test', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', '100');
			$table->text('description');

			$table->integer('type')->default(0);
			$table->integer('duration')->default(0);
			$table->string('version')->default('1');

			$table->integer('category_id')->unsigned()->nullable();
			$table->integer('user_id')->unsigned()->nullable();

			$table->boolean('active')->default(0);
			$table->boolean('display_result')->default(0);

			$table->timestamps();

			$table->foreign('category_id')->references('id')->on('department');
			$table->foreign('user_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('test');
	}

}
