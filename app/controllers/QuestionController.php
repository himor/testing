<?php

/**
 * Class QuestionController
 *
 * @author Mike Gordo <m.gordo@cityads.ru>
 */
class QuestionController extends BaseController
{
	/**
	 * Создание нового вопроса
	 *
	 * @param $id test id
	 *
	 * @return mixed
	 */
	public function createAction($id)
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
		if (count(Result::where('test_id', $id)->get())) {
			return Redirect::route('tests.index')
				->with('error', 'Нельзя редактировать тест, на который есть ответы');
		}

		$question          = new Question();
		$question->test_id = $id;

		return View::make('question.create', [
				'test'     => $test,
				'question' => $question,
			]
		);
	}

	/**
	 * Сохранение нового вопроса
	 *
	 * @return mixed
	 */
	public function storeAction()
	{
		$data = Input::all();
		$num  = $data['number_of_answers'];

		$test = Test::find($data['test_id']);

		if (is_null($test))
			return Redirect::route('tests.index')
				->with('error', 'Incorrect test id');

		if (Auth::user()->getId() != $test->user_id)
			return Redirect::route('tests.index')
				->with('error', 'Нельзя редактировать тест созданный другим пользователем');

		/**
		 * Проверим, нет ли ответов по этому тесту
		 */
		if (count(Result::where('test_id', $test->id)->get())) {
			return Redirect::route('tests.index')
				->with('error', 'Нельзя редактировать тест, на который есть ответы');
		}

		$validation = Validator::make([
			'text' => $data['text']
		], Question::$rules);

		if (!$validation->passes()) {
			return Redirect::route('question.create', ['id' => $test->id])
				->withInput()
				->withErrors($validation)
				->with('message', 'There were validation errors.');
		}

		$question          = new Question();
		$question->text    = $data['text'];
		$question->type    = $data['type'];
		$question->test_id = $test->id;

		$question->save();

		/**
		 * Create answers
		 */
		for ($i = 1; $i < $num; $i++) {
			if (!isset($data['a_' . $i . '_text']) || !trim($data['a_' . $i . '_text']))
				continue;
			$answer              = new Answer();
			$answer->question_id = $question->id;
			$answer->text        = trim($data['a_' . $i . '_text']);
			$answer->weight      = (int)$data['a_' . $i . '_weight'];
			$answer->is_correct  = isset($data['a_' . $i . '_correct']) ? true : false;

			if ($answer->is_correct && !$answer->weight)
				$answer->weight = 1;

			if (!$answer->is_correct)
				$answer->weight = 0;

			$answer->save();
		}

		return Redirect::route('tests.show', $test->id);
	}

}