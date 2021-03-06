<?php

/**
 * Class TestsController
 *
 * @author Mike Gordo <mgordo@live.com>
 */
class TestsController extends BaseController {

	protected $layout = 'layout.tests';

	/**
	 * Display all tests
	 */
	public function indexAction() {
		$tests = Test::orderBy('name', 'asc')
			->orderBy('version', 'desc')->get();

		return View::make('tests.index', ['tests' => $tests]);
	}

	/**
	 * Create new test
	 *
	 * @return mixed
	 */
	public function createAction() {
		$test           = new Test();
		$test->name     = 'Мой тест, ' . date('d.m.Y');
		$test->duration = 10;
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
	 * Create new version of the test
	 *
	 * @param $id
	 */
	public function versionAction($id) {
		$test = Test::find($id);

		if (is_null($test))
			return Redirect::route('tests.index')
				->with('error', 'Incorrect test id');

		$test->version  = (int)$test->version + 1;
		$test->duration = $test->duration / 60;

		$categories           = Category::all();
		$selectedCategories   = array();
		$selectedCategories[] = 'Не выбрана';

		foreach ($categories as $category) {
			$selectedCategories[$category->id] = $category->name;
		}

		return View::make('tests.version', [
				'test'       => $test,
				'categories' => $selectedCategories,
			]
		);
	}

	/**
	 * Store new version of the test
	 */
	public function storeVersionAction() {
		$data = Input::all();
		$id   = $data['id'];
		unset($data['id']);

		$validation = Validator::make($data, Test::$rules);

		if (!$validation->passes()) {
			return Redirect::route('version.create', ['id' => $id])
				->withInput()
				->withErrors($validation)
				->with('message', 'There were validation errors.');
		}

		if (!$data['category_id']) {
			return Redirect::route('version.create', ['id' => $id])
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
			 * This test exists, generate new version
			 */
			$data['version'] = $this->getNextVersion($data['name']);
		}

		$data['user_id']  = Auth::user()->getId();
		$data['active']   = false;
		$data['duration'] = $data['duration'] * 60;

		$test = Test::create($data);

		/**
		 * Clone all Questions and Answers
		 */
		$questions = Question::where('test_id', $id)->get();
		foreach ($questions as $q) {
			$new          = $q->replicate();
			$new->test_id = $test->id;
			$new->save();

			$answers = Answer::where('question_id', $q->id)->get();
			foreach ($answers as $a) {
				$newa              = $a->replicate();
				$newa->question_id = $new->id;
				$newa->save();
			}
		}

		return Redirect::route('tests.show', $test->id);
	}

	/**
	 * Store new test
	 *
	 * @return mixed
	 */
	public function storeAction() {
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
			 * This test exists, generate new version
			 */
			$data['version'] = $this->getNextVersion($data['name']);
		}

		$data['user_id']  = Auth::user()->getId();
		$data['active']   = false;
		$data['duration'] = $data['duration'] * 60;

		$test = Test::create($data);

		return Redirect::route('tests.show', $test->id);
	}

	/**
	 * Display one test by id
	 *
	 * @param $id
	 */
	public function showAction($id) {
		$test = Test::find($id);

		if (is_null($test))
			return Redirect::route('tests.index')
				->with('error', 'Incorrect test id');

		/**
		 * Check if we have any answers already
		 */
		$results = count(Result::where('test_id', $id)->get());

		/**
		 * Load all the questions in the right order
		 */
		$questions = Question::where('test_id', $id)->orderBy('number', 'asc')->get();

		return View::make('tests.show', [
				'test'      => $test,
				'results'   => $results,
				'questions' => $questions,
			]
		);
	}

	/**
	 * Display a page where we can edit the test
	 *
	 * @param $id
	 */
	public function editAction($id) {
		$test = Test::find($id);

		if (is_null($test))
			return Redirect::route('tests.index')
				->with('error', 'Incorrect test id');

		/**
		 * Check if we have any answers already
		 */
		$results = count(Result::where('test_id', $id)->get());

		$categories           = Category::all();
		$selectedCategories   = array();
		$selectedCategories[] = 'Не выбрана';

		foreach ($categories as $category) {
			$selectedCategories[$category->id] = $category->name;
		}

		$test['duration'] = $test['duration'] / 60;

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
	public function updateAction($id) {
		$test = Test::find($id);

		if (is_null($test))
			return Redirect::route('tests.index')
				->with('error', 'Incorrect test id');

		$validation = Validator::make(Input::all(), Test::$rules);

		if (!$validation->passes()) {
			return Redirect::route('tests.edit', $id)
				->withInput()
				->withErrors($validation)
				->with('message', 'There were validation errors.');
		}

		$data = Input::all();

		$data['duration'] = $data['duration'] * 60;

		/**
		 * Check if we have any answers already
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
			 * This test exists, generate new version
			 */
			$data['version'] = $this->getNextVersion($data['name']);
		}

		$test->update($data);
		$test->active = isset($data['active']) && $data['active'];
		$test->save();

		return Redirect::route('tests.show', $id);
	}

	/**
	 * Delete the test
	 *
	 * @param $id
	 */
	public function deleteAction($id) {
		$test = Test::find($id);

		if (is_null($test))
			return Redirect::route('tests.index')
				->with('error', 'Incorrect test id');

		/**
		 * Get the list of answers
		 */
		$questions = Question::where('test_id', $id)->get();
		foreach ($questions as $q) {
			DB::table('answer')->where('question_id', $q->id)->delete();
		}

		DB::table('token')->where('test_id', $id)->delete();
		DB::table('result')->where('test_id', $id)->delete();
		DB::table('question')->where('test_id', $id)->delete();
		DB::table('test')->where('id', $id)->delete();

		return Redirect::route('tests.index');
	}

	/**
	 * Get next version for the test by its name
	 *
	 * @param $name
	 *
	 * @return int
	 */
	private function getNextVersion($name) {
		$tests = Test::where('name', $name)->get();
		$max   = 0;
		foreach ($tests as $test) {
			$max = (int)$test->version > $max ? (int)$test->version : $max;
		}

		return ++$max;
	}

}