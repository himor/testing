<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Token extends Eloquent
{
	const TOKEN_STATUS_EMPTY   = 0;
	const TOKEN_STATUS_STARTED = 1;
	const TOKEN_STATUS_EXPIRED = 2;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'token';

	/**
	 * Validation rules
	 */
	public static $start_rules = [
		'firstName'     => 'required|min:2',
		'lastName'      => 'required|min:2',
	];

	protected $guarded = ['id'];

	/**
	 * Generate token
	 *
	 * @param string $name
	 *
	 * @return string
	 */
	public function generate($name = '')
	{
		return md5(microtime()) . md5($name . microtime(true));
	}

	/**
	 * Related Test
	 */
	public function test()
	{
		return $this->belongsTo('Test');
	}

}
