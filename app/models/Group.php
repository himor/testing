<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Group extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'group';

	/**
	 * Validation rules
	 */
	public static $rules = [
		'name' => 'required|min:2',
	];

	protected $guarded = ['id'];

}
