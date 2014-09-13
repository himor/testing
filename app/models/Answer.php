<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Answer extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'answer';

	/**
	 * Validation rules
	 */
	public static $rules = [
		'text' => 'required|min:2',
	];

	protected $guarded = ['id'];

	/**
	 * Related Question
	 */
	public function question()
	{
		return $this->belongsTo('question');
	}

}
