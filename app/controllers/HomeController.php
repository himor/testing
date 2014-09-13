<?php

/**
 * Class HomeController
 *
 * @author Mike Gordo <m.gordo@cityads.ru>
 */
class HomeController extends BaseController
{
	public function defaultAction()
	{
		/**
		 * Проверим, нет ли токена в нашей сессии?
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
		 * По умолчанию мы редиректим на логин, если нет сессии
		 */

		return Redirect::route('admin');
	}

	/**
	 * Сообщаем пользователю информацию
	 *
	 * @return mixed
	 */
	public function infoAction()
	{
		return View::make('base.info');
	}

}
