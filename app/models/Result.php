<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Result extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'result';

	/**
	 * Validation rules
	 */
	public static $rules = [
		'token' => 'required|min:64',
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
	 * Related Question
	 */
	public function question()
	{
		return $this->belongsTo('Question');
	}

}
