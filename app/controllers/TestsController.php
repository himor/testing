<?php

/**
 * Class TestsController
 *
 * @author Mike Gordo <m.gordo@cityads.ru>
 */
class TestsController extends BaseController
{
	protected $layout = 'layout.tests';

	/**
	 * Display all tests
	 */
	public function indexAction()
	{
		$tests = Test::all();

		return View::make('tests.index', ['tests' => $tests]);
	}

	/**
	 * Создание нового теста
	 *
	 * @return mixed
	 */
	public function createAction()
	{
		$test           = new Test();
		$test->name     = 'Мой тест, ' . date('d.m.Y');
		$test->duration = 600;
		$test->version  = 1;

		$categories           = Category::all();
		$selectedCategories   = array();
		$selectedCategories[] = 'Не выбрана';

		foreach ($categories as $category) {
			$selectedCategories[$category->id] = $category->name;
		}

		return View::make('tests.create', [
				'test'       => $test,
				'categories' => $selectedCategories,
			]
		);
	}

	/**
	 * Сохранение нового теста
	 *
	 * @return mixed
	 */
	public function storeAction()
	{
		$data       = Input::all();
		$validation = Validator::make($data, Test::$rules);

		if (!$validation->passes()) {
			return Redirect::route('tests.create')
				->withInput()
				->withErrors($validation)
				->with('message', 'There were validation errors.');
		}

		if (!$data['category_id']) {
			return Redirect::route('tests.create')
				->withInput()
				->with('message', 'Укажите категорию теста.');
		}

		/**
		 * Check name duplicates
		 */
		if (count(Test::where('name', $data['name'])
			->where('version', (int)$data['version'])->get())
		) {
			/**
			 * Такой тест существует, поменяем версию
			 */
			$data['version'] = (int)$data['version'] + 1;
		}

		$data['user_id'] = Auth::user()->getId();
		$data['active']  = false;

		$test = Test::create($data);

		return Redirect::route('tests.show', $test->id);
	}

	/**
	 * Display one test by id
	 *
	 * @param $id
	 */
	public function showAction($id)
	{
		$test = Test::find($id);

		if (is_null($test))
			return Redirect::route('tests.index')
				->with('error', 'Incorrect test id');

		return View::make('tests.show', ['test' => $test]);
	}

	/**
	 * Display a page where we can edit the test
	 *
	 * @param $id
	 */
	public function editAction($id)
	{
		$test = Test::find($id);

		if (is_null($test))
			return Redirect::route('tests.index')
				->with('error', 'Incorrect test id');

		if (Auth::user()->getId() != $test->user_id)
			return Redirect::route('tests.index')
				->with('error', 'Нельзя редактировать тест созданный другим пользователем');

		/**
		 * Проверим, нет ли ответов по этому тесту
		 */
		$results = count(Result::where('test_id', $id)->get());

		$categories           = Category::all();
		$selectedCategories   = array();
		$selectedCategories[] = 'Не выбрана';

		foreach ($categories as $category) {
			$selectedCategories[$category->id] = $category->name;
		}

		return View::make('tests.edit', [
				'test'       => $test,
				'categories' => $selectedCategories,
				'results'    => $results,
			]
		);
	}

	/**
	 * Update the test
	 *
	 * @param $id
	 */
	public function updateAction($id)
	{
		$test = Test::find($id);

		if (is_null($test))
			return Redirect::route('tests.index')
				->with('error', 'Incorrect test id');

		if (Auth::user()->getId() != $test->user_id)
			return Redirect::route('tests.index')
				->with('error', 'Нельзя редактировать тест созданный другим пользователем');

		$validation = Validator::make(Input::all(), Test::$rules);

		if (!$validation->passes()) {
			return Redirect::route('tests.edit', $id)
				->withInput()
				->withErrors($validation)
				->with('message', 'There were validation errors.');
		}

		$data = Input::all();

		/**
		 * Проверим, нет ли ответов по этому тесту
		 */
		$results = count(Result::where('test_id', $id)->get());
		if ($results > 0) {
			unset($data['type']);
		}

		/**
		 * Check name duplicates
		 */
		if (count(Test::where('name', $data['name'])->
			where('version', $data['version'])->
			where('id', '!=', $id)->get())
		) {
			/**
			 * Такой тест существует, поменяем версию
			 */
			$data['version'] = (int)$data['version'] + 1;
		}

		$test->update($data);
		$test->save();

		return Redirect::route('tests.show', $id);
	}

	/**
	 * Delete the test
	 *
	 * @param $id
	 */
	public function deleteAction($id)
	{
		$test = Test::find($id);

		if (is_null($test))
			return Redirect::route('tests.index')
				->with('error', 'Incorrect test id');

		if (Auth::user()->getId() != $test->user_id)
			return Redirect::route('tests.index')
				->with('error', 'Нельзя удалить тест созданный другим пользователем');

		/**
		 * Проверим, нет ли ответов по этому тесту
		 */
		if (count(Result::where('test_id', $id)->get())) {
			return Redirect::route('tests.index')
				->with('error', 'Нельзя удалить тест, на который есть ответы');
		}

		DB::table('test')->where('id', $id)->delete();

		return Redirect::route('tests.index');
	}

}