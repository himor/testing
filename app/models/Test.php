<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Test extends Eloquent
{
	const TEST_TYPE_SUMMA  = 1;
	const TEST_TYPE_PSYCHO = 2;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'test';

	/**
	 * Validation rules
	 */
	public static $rules = [
		'name' => 'required|min:2',
	];

	protected $guarded = ['id'];

	/**
	 * Related Category
	 */
	public function category()
	{
		return $this->belongsTo('Category');
	}

	/**
	 * Related User
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}

	/**
	 * Test one-to-many Question
	 *
	 * @return mixed
	 */
	public function questions()
	{
		return $this->hasMany('Question');
	}

	/**
	 * Test one-to-many Scale
	 *
	 * @return mixed
	 */
	public function scales()
	{
		return $this->hasMany('Scale');
	}

	/**
	 * Test one-to-many Result
	 *
	 * @return mixed
	 */
	public function results()
	{
		return $this->hasMany('Result');
	}

	/**
	 * Test one-to-many Token
	 *
	 * @return mixed
	 */
	public function tokens()
	{
		return $this->hasMany('Token');
	}

}
