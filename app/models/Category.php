<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Category extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'category';

	/**
	 * Validation rules
	 */
	public static $rules = [
		//'name' => 'required|min:2',
	];

	protected $guarded = ['id'];

	/**
	 * Category one-to-many Test
	 *
	 * @return mixed
	 */
	public function tests()
	{
		return $this->hasMany('Test');
	}
}
