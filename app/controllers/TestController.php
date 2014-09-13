<?php

/**
 * Class TestController
 *
 * @author Mike Gordo <m.gordo@cityads.ru>
 */
class TestController extends BaseController
{
	public function indexAction()
	{
		$token = $this->getToken();
		if (!$token) {
			return Redirect::route('info')
				->with('message', 'Токен не найден');
		}

		if ($token->status != Token::TOKEN_STATUS_STARTED) {
			return Redirect::route('token.index', ['token' => $token->token]);
		}

		if (!$this->isTokenValid($token)) {
			Session::forget('token_string');
			$token->status = Token::TOKEN_STATUS_EXPIRED;
			$token->save();

			return Redirect::route('info')->with('message', 'Время теста истекло');
		}

		/**
		 * Тут получаем следующий вопрос, выводим его пользователю
		 * Пока хер знает как
		 */

	}

	/**
	 * Ajax запрос на валидность токена
	 *
	 * @return mixed
	 */
	public function checkTime()
	{
		$token = $this->getToken();
		if (!$token) {
			return Response::json(['error' => 'Токен не найден'], 400);
		}

		$started  = $token->start;
		$time     = time() - $started;
		$duration = $token->test->duration;

		return Response::json(
			[
				'time'     => $time,
				'duration' => $duration,
				'status'   => $time < $duration
			]
		);
	}
}