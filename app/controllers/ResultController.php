<?php

/**
 * Class ResultController
 *
 * @author Mike Gordo <mgordo@live.com>
 */
class ResultController extends BaseController {

	protected $layout = 'layout.tests';

	private function getResultList($id) {
		$test = Test::find($id);

		if (is_null($test))
			return Redirect::route('tests.index')
				->with('error', 'Incorrect test id');

		/* query with no grouping for test duration calculation */
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
			->leftJoin('department', 'department.id', '=', 'token.department_id')
			->leftJoin('group', 'group.id', '=', 'token.group_id')
			->select(DB::raw('token.*, department.name as dept_name, group.name as group_name'))
			->whereIn('token', $tokens)
			->get();

		$tokens = [];
		foreach ($tokens_ as $token) {
			$tokens[$token->token] = $token;
		}

		/* finish minus start */
		$ends = [];
		foreach ($results_ as $result) {
			$start    = $tokens[$result->token]->start;
			$duration = $result->created_at->format('U') - $start;
			if (!isset($ends[$result->token]) || (isset($ends[$result->token]) && $ends[$result->token] < $duration)) {
				$ends[$result->token] = $duration;
			}
		}

		/* make time human-readable */
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

		return [
			'test'            => $test,
			'total_questions' => count($test->questions),
			'total_weight'    => $tw,
			'results'         => $results,
			'tokens'          => $tokens,
			'duration'        => $ends,
		];
	}

	/**
	 * Display list of results
	 *
	 * @param $id
	 *
	 * @return array
	 */
	public function indexAction($id) {
		$results = $this->getResultList($id);

		if (!is_array($results))
			return $results;

		return View::make('tests.results_index', $results);
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

		$single = Result::find($rid);

		if (is_null($single) || $single->test_id != $id)
			return Redirect::route('tests.index')
				->with('error', 'Невозможно найти результаты');

		$results = Result::where('test_id', $id)
			->where('token', $single->token)
			->orderBy('question_id', 'asc')
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

		if (is_null($test))
			return Response::json(['error' => 'Access denied'], 400);

		$result->is_correct = $data['is_correct'] ? true : false;

		if ($result->is_correct) {
			$result->weight = (isset($data['weight']) && $data['weight']) ? (int)$data['weight'] : 1;
		} else {
			$result->weight = 0;
		}

		$result->save();

		return Redirect::back()->with('info', 'Ответ отредактирован.');
	}

	/**
	 * Output results in CSV format
	 *
	 * @param $id
	 *
	 * @return array
	 */
	public function indexCsvAction($id) {
		$results = $this->getResultList($id);

		$delimeter = "\t";

		if (!is_array($results))
			return $results;

		$test            = $results['test'];
		$total_questions = $results['total_questions'];
		$total_weight    = $results['total_weight'];
		$tokens          = $results['tokens'];
		$duration        = $results['duration'];
		$results         = $results['results'];

		$output = [
			mb_convert_encoding("{$delimeter}Имя Фамилия{$delimeter}Департамент{$delimeter}Отдел{$delimeter}Результат{$delimeter}Длительность", 'CP1251', 'UTF-8')
		];
		foreach ($results as $item) {
			$row      = [];
			$row[]    = count($output);
			$row[]    = $tokens[$item->token]->firstName . ' ' . $tokens[$item->token]->lastName;
			$row[]    = $tokens[$item->token]->dept_name;
			$row[]    = $tokens[$item->token]->group_name;
			$row[]    = $item->total_weight . '/' . $total_weight . ' (ответов ' . $item->answered . '/' . $total_questions . ')';
			$row[]    = $duration[$item->token];
			$r        = implode($delimeter, $row);
			$output[] = mb_convert_encoding($r, 'CP1251', 'UTF-8');
		}

		$headers = array(
			'Content-Type'        => 'text/csv',
			'Content-Disposition' => 'attachment; filename="Results ' . $test->name . '.csv";',
		);

		return Response::make(implode("\n", $output), 200, $headers);
	}

	/**
	 * Output results in Excel format
	 *
	 * @param $id
	 *
	 * @return array
	 */
	public function indexXlsAction($id) {
		$results = $this->getResultList($id);

		if (!is_array($results))
			return $results;

		$test            = $results['test'];
		$total_questions = $results['total_questions'];
		$total_weight    = $results['total_weight'];
		$tokens          = $results['tokens'];
		$duration        = $results['duration'];
		$results         = $results['results'];

		$output = [
			['', 'Имя, Фамилия', 'Департамент', 'Отдел', 'Результат', 'Длительность'],
		];

		foreach ($results as $item) {
			$row      = [];
			$row[]    = count($output);
			$row[]    = $tokens[$item->token]->firstName . ' ' . $tokens[$item->token]->lastName;
			$row[]    = $tokens[$item->token]->dept_name;
			$row[]    = $tokens[$item->token]->group_name;
			$row[]    = $item->total_weight . '/' . $total_weight . ' (ответов ' . $item->answered . '/' . $total_questions . ')';
			$row[]    = $duration[$item->token];
			$r        = implode("\t", $row);
			$output[] = $row; //mb_convert_encoding($r, 'CP1251', 'UTF-8');
		}

//		foreach ($output as $key => $value) {
//			foreach ($value as $z => $word) {
//				$output[$key][$z] = mb_convert_encoding($word, 'CP1251', 'UTF-8');
//			}
//		}

		Excel::create('Results ' . $test->name, function ($excel) use ($output) {
			$excel->sheet('Results', function ($sheet) use ($output) {

				$sheet->fromArray($output);

			});
		})->export('xls');
	}
}



