<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Question extends Eloquent
{
	const TYPE_RADIO    = 1;
	const TYPE_CHECKBOX = 2;
	const TYPE_STRING   = 3;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'question';

	/**
	 * Validation rules
	 */
	public static $rules = [
		'text' => 'required|min:2',
	];

	protected $guarded = ['id'];

	/**
	 * Related Test
	 */
	public function test()
	{
		return $this->belongsTo('Test');
	}

	/**
	 * Question one-to-many Answer
	 *
	 * @return mixed
	 */
	public function answers()
	{
		return $this->hasMany('Answer');
	}

}
