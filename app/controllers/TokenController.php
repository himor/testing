<?php

/**
 * Class TokenController
 *
 * @author Mike Gordo <m.gordo@cityads.ru>
 */
class TokenController extends BaseController
{
	//protected $layout = 'layout.groups';

	/**
	 * Check token
	 */
	public function indexAction($tokenString)
	{
		Assets::reset()->add('main');

		$token = Token::where('token', $tokenString)->get()->first();

		if (!count($token)) {
			return Redirect::route('info')
				->with('message', 'Токен не найден');
		}

		if (!$token->test->active) {
			return Redirect::route('info')
				->with('message', 'Тест закрыт для тестирования');
		}

		switch ($token->status) {
			case Token::TOKEN_STATUS_EMPTY:
			case Token::TOKEN_STATUS_STARTED:
				Session::put('token_string', $tokenString);

				return Redirect::route('start.index');
				break;
			case Token::TOKEN_STATUS_EXPIRED:
				Session::forget('token_string');

				return Redirect::route('info')->with('message', 'Токен просрочен');
				break;
			default:
				return Redirect::route('info')->with('message', 'Неожиданный статус токена');
		}
	}

	/**
	 * Start test
	 */
	public function startIndexAction()
	{
		Assets::reset()->add('main');

		$token = $this->getToken();
		if (!$token) {
			return Redirect::route('info')
				->with('message', 'Токен не найден');
		}

		if ($token->status == Token::TOKEN_STATUS_EMPTY) {
			/**
			 * вывести форму где пользователь введёт свои данные
			 */
			$departments = Department::all();
			$groups      = Group::all();

			$selectedDepartments = array();
			$selectGroups        = array();

			$selectedDepartments[] = 'Не выбран';
			$selectGroups[]        = 'Не выбран';

			foreach ($departments as $department) {
				$selectedDepartments[$department->id] = $department->name;
			}

			foreach ($groups as $group) {
				$selectGroups[$group->id] = $group->name;
			}

			return View::make('test.start', [
					'token'       => $token,
					'departments' => $selectedDepartments,
					'groups'      => $selectGroups
				]
			);
		} elseif ($token->status == Token::TOKEN_STATUS_STARTED) {
			if ($this->isTokenValid($token)) {
				return Redirect::route('test.index');
			} else {
				Session::forget('token_string');
				$token->status = Token::TOKEN_STATUS_EXPIRED;
				$token->save();

				return Redirect::route('info')->with('message', 'Время теста истекло');
			}
		}

	}

	/**
	 * Сохранить данные пользователя и начать тест
	 */
	public function startAction()
	{
		Assets::reset()->add('main');

		$token = $this->getToken();
		if (!$token) {
			return Redirect::route('info')
				->with('message', 'Токен не найден');
		}

		$data       = Input::all();
		$validation = Validator::make($data, Token::$start_rules);

		if (!$validation->passes()) {
			return Redirect::route('start.index')
				->withInput()
				->withErrors($validation)
				->with('message', 'Все поля обязательны!');
		}

		if (!$data['department_id'] || !$data['group_id']) {
			return Redirect::route('start.index')
				->withInput()
				->with('message', 'Выберите департамент и отдел!');
		}

		$token->update($data);
		$token->start  = time();
		$token->status = Token::TOKEN_STATUS_STARTED;
		$token->save();

		return Redirect::route('test.index');
	}

	/**
	 * Создание токена для теста
	 *
	 * @param $id
	 */
	public function createAction($id)
	{
		if (!Auth::user()) {
			return Redirect::route('admin');
		}

		$test = Test::find($id);

		if (is_null($test)) {
			return Redirect::route('info')
				->with('message', 'Тест не найден');
		}

		$token = new Token();
		$token->token = $token->generate($test->name);
		$token->test_id = $id;
		$token->save();

		return View::make('test.token', ['token' => $token->token]);
	}

}