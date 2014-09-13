<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTokenTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('token', function (Blueprint $table) {
			$table->increments('id');
			$table->string('token', '100');

			$table->integer('test_id')->unsigned()->nullable();

			$table->string('firstName', '50')->default('');
			$table->string('lastName', '50')->default('');

			$table->integer('department_id')->unsigned()->nullable();
			$table->integer('group_id')->unsigned()->nullable();

			$table->integer('status')->default(0);

			$table->integer('start')->unsigned()->nullable();

			$table->timestamps();

			$table->foreign('department_id')->references('id')->on('department');
			$table->foreign('group_id')->references('id')->on('group');
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
		Schema::drop('token');
	}

}
