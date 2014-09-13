<?php

class BaseController extends Controller
{

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if (!is_null($this->layout)) {
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 * Returns $token or false
	 *
	 * @return bool
	 */
	protected function getToken()
	{
		$tokenString = Session::get('token_string', false);
		if (!$tokenString) {
			return false;
		}

		$token = Token::where('token', $tokenString)->get()->first();
		if (!count($token)) {
			return false;
		} else {
			return $token;
		}
	}

	/**
	 * Check if token expired
	 *
	 * @param Token $token
	 *
	 * @return bool
	 */
	protected function isTokenValid(Token $token)
	{
		$started  = $token->start;
		$time     = time() - $started;
		$duration = $token->test->duration;

		return $time < $duration;
	}
}
