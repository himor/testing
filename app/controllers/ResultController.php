<?php

/**
 * Class ResultController
 *
 * @author Mike Gordo <m.gordo@cityads.ru>
 */
class ResultController extends BaseController {
	protected $layout = 'layout.tests';

	/**
	 * Display list of results
	 *
	 * @param $id
	 */
	public function indexAction($id) {
		$test = Test::find($id);

		if (is_null($test))
			return Redirect::route('tests.index')
				->with('error', 'Incorrect test id');

//		if (Auth::user()->getId() != $test->user_id)
//			return Redirect::route('tests.index')
//				->with('error', 'Нельзя просмотреть результаты теста, созданного другим пользователем');

		/* запрос без группировки для расчёта продолжительности тестов */
		$results_ = Result::where('test_id', $id)
			->orderBy('created_at', 'desc')
			->get();

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

		/* когда закончили тесты минус когда начали */
		$ends = [];
		foreach ($results_ as $result) {
			$start    = $tokens[$result->token]->start;
			$duration = $result->created_at->format('U') - $start;
			if (!isset($ends[$result->token]) || (isset($ends[$result->token]) && $ends[$result->token] < $duration)) {
				$ends[$result->token] = $duration;
			}
		}

		/* нормализация времени */
		foreach ($ends as $key => $value) {
			$min        = (int)($value / 60);
			$sec        = $value - $min * 60;
			$ends[$key] = ($min < 10 ? '0' . $min : $min) . ':' . ($sec < 10 ? '0' . $sec : $sec);
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
				'tokens'          => $tokens,
				'duration'        => $ends,
			]
		);
	}

	/**
	 * Display one result
	 *
	 * @param $id
	 * @param $rid
	 */
	public function showAction($id, $rid) {
		$test = Test::find($id);

		if (is_null($test))
			return Redirect::route('tests.index')
				->with('error', 'Incorrect test id');

//		if (Auth::user()->getId() != $test->user_id)
//			return Redirect::route('tests.index')
//				->with('error', 'Нельзя просмотреть результаты теста, созданного другим пользователем');

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
		$max   = 0;
		foreach ($results as $result) {
			$score += $result->weight;
			if ($max < $result->created_at->format('U')) {
				$max = $result->created_at->format('U');
			}
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

		$token = Token::where('token', $result->token)->get();
		$ends  = $max - $token[0]->start;
		$min   = (int)($ends / 60);
		$sec   = $ends - $min * 60;
		$ends  = ($min < 10 ? '0' . $min : $min) . ':' . ($sec < 10 ? '0' . $sec : $sec);

		return View::make('tests.results_show', [
				'token'           => Token::where('token', $single->token)->get()[0],
				'test'            => $test,
				'total_questions' => count($test->questions),
				'total_weight'    => $tw,
				'results'         => $results,
				'weights'         => $weights,
				'score'           => $score,
				'duration'        => $ends,
			]
		);
	}

	/**
	 * Mark single answer as correct by id
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function resultCorrect($id) {
		$result = Result::find($id);
		$data   = Input::all();

		if (is_null($result))
			return Response::json(['error' => 'Result not found'], 400);

		$test = $result->test;

		if (is_null($test) || Auth::user()->getId() != $test->user_id)
			return Response::json(['error' => 'Access denied'], 400);

		$result->is_correct = $result->is_correct ? false : true;

		if ($result->is_correct) {
			$result->weight = (isset($data['weight']) && $data['weight']) ? (int)$data['weight'] : 1;
		} else {
			$result->weight = 0;
		}

		return Response::json(
			[
				'status' => $result->is_correct,
				'weight' => $result->weight,
			]
		);
	}
}



