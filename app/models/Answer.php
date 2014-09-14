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

	public $hash = '';

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
		return $this->belongsTo('Question');
	}

	public function withHash()
	{
		$this->hash = $this->question->test->id . '-' . substr(md5($this->text . microtime()), 0, 6);
		return $this;
	}

}
