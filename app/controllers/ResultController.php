<?php

/**
 * Class ResultController
 *
 * @author Mike Gordo <m.gordo@cityads.ru>
 */
class ResultController extends BaseController
{
	protected $layout = 'layout.tests';

	/**
	 * Display list of results
	 *
	 * @param $id
	 */
	public function indexAction($id)
	{
		$test = Test::find($id);

		if (is_null($test))
			return Redirect::route('tests.index')
				->with('error', 'Incorrect test id');

		if (Auth::user()->getId() != $test->user_id)
			return Redirect::route('tests.index')
				->with('error', 'Нельзя просмотреть результаты теста, созданного другим пользователем');

		$results = Result::where('test_id', $id)
			->orderBy('created_at', 'desc')
			->select(DB::raw('*, SUM(weight) as total_weight, COUNT(id) as answered'))
			->groupBy('token')
			->get();

		if (!count($results)) {
			return Redirect::route('tests.index')
				->with('error', 'Отсутствуют результаты теста');
		}

		$tokens = [];
		foreach ($results as $result) {
			$tokens[] = $result->token;
		}

		$tokens_ = DB::table('token')
			->join('department', 'department.id', '=', 'token.department_id')
			->select(DB::raw('token.*, department.name as dept_name'))
			->whereIn('token', $tokens)
			->get();

		$tokens = [];
		foreach ($tokens_ as $token) {
			$tokens[$token->token] = $token;
		}

		$tw = 0;
		foreach ($test->questions as $q) {
			foreach ($q->answers as $a) {
				if (!$a->is_correct)
					continue;
				$tw += ($q->type == Question::TYPE_STRING) ? 1 : $a->weight;
			}
			if ($q->type == Question::TYPE_STRING) {
				$tw += 1;
			}
		}

		return View::make('tests.results_index', [
				'test'            => $test,
				'total_questions' => count($test->questions),
				'total_weight'    => $tw,
				'results'         => $results,
				'tokens'          => $tokens
			]
		);
	}

	/**
	 * Display one result
	 *
	 * @param $id
	 * @param $rid
	 */
	public function showAction($id, $rid)
	{
		$test = Test::find($id);

		if (is_null($test))
			return Redirect::route('tests.index')
				->with('error', 'Incorrect test id');

		if (Auth::user()->getId() != $test->user_id)
			return Redirect::route('tests.index')
				->with('error', 'Нельзя просмотреть результаты теста, созданного другим пользователем');

		$single = Result::find($rid);

		if (is_null($single) || $single->test_id != $id)
			return Redirect::route('tests.index')
				->with('error', 'Невозможно найти результаты');

		$results = Result::where('test_id', $id)
			->where('token', $single->token)
			->orderBy('created_at', 'desc')
			->get();

		if (!count($results)) {
			return Redirect::route('tests.index')
				->with('error', 'Отсутствуют результаты теста');
		}

		$score = 0;
		foreach ($results as $result) {
			$score += $result->weight;
		}

		$weights = [];
		$tw      = 0;
		foreach ($test->questions as $q) {
			$weights[$q->id] = 0;
			foreach ($q->answers as $a) {
				if (!$a->is_correct)
					continue;
				$weights[$q->id] += $a->weight;
				$tw += $a->weight;
			}
			if ($q->type == Question::TYPE_STRING) {
				$weights[$q->id] += 1;
				$tw += 1;
			}
		}

		return View::make('tests.results_show', [
				'token'           => Token::where('token', $single->token)->get()[0],
				'test'            => $test,
				'total_questions' => count($test->questions),
				'total_weight'    => $tw,
				'results'         => $results,
				'weights'         => $weights,
				'score'           => $score
			]
		);
	}
}



