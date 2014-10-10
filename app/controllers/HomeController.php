<?php

/**
 * Class HomeController
 *
 * @author Mike Gordo <mgordo@live.com>
 */
class HomeController extends BaseController {

	public function defaultAction() {
		/**
		 * Check is session contains token
		 */
		$token = $this->getToken();

		if (!$token) {
			Session::forget('token_string');
		} elseif ($token->status == Token::TOKEN_STATUS_EXPIRED) {
			Session::forget('token_string');
		} else {
			return Redirect::route('token.index', ['token' => $token->token]);
		}

		/**
		 * By default redirect to login if no token found
		 */

		return Redirect::route('admin');
	}

	/**
	 * Display information to user
	 *
	 * @return mixed
	 */
	public function infoAction() {
		return View::make('base.info');
	}

}
