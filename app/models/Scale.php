<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Scale extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'scale';

	/**
	 * Validation rules
	 */
	public static $rules = [
		//'text' => 'required|min:2',
	];

	protected $guarded = ['id'];

	/**
	 * Related Test
	 */
	public function test()
	{
		return $this->belongsTo('Test');
	}

}
