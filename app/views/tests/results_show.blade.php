@extends('layout.tests')

@section('title')
<div class="page-header">
	<h1>Просмотр результатов {{ $test->name }} - {{ $test->version }}</h1>
</div>
@stop

@section('menu')
<div class="btn-group">
  	<a class="btn btn-default" href="{{ URL::route('result.index', array('id' => $test->id)) }}">
  		<span class="glyphicon glyphicon-share-alt"></span>
    	Вернуться к списку
    </a>
</div>
@stop

@section('content')
@if (Session::has('error'))
<div class="error">
	<p>{{ Session::get('error') }}</p>
</div>
@endif

@if (Session::has('info'))
<div class="alert alert-info" role="alert">{{ Session::get('info') }}</div>
@endif

<div class="row">
	<div class="col-md-6">
		<h2>Сводка:</h2>
		<table class="table table-bordered">
			<tbody>
				<tr>
					<td>Имя</td>
					<td>{{ $token->firstName }} {{ $token->lastName }}</td>
				</tr>
				<tr>
					<td>Результат</td>
					@if ($score == $total_weight)
					<td class="success">
					@elseif ($score == 0)
					<td class="danger">
					@else
					<td>
					@endif
						<h1>{{ $score }}</h1>
					</td>
				</tr>
				<tr>
					<td>Максимальное количество баллов </td>
					<td>{{ $total_weight }}</td>
				</tr>
				<tr>
					<td>Всего вопросов</td>
					<td>{{ $total_questions }}</td>
				</tr>
				<tr>
					<td>Всего ответов</td>
					<td>{{ count($results) }}</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h2>Все ответы:</h2>
		<table class="table table-bordered">
			<thead>
			<th>#</th>
			<th>Вопрос</th>
			<th>Ответ</th>
			<th>Баллы</th>
			<th>Максимум</th>
			</thead>
			<tbody>
			<?php $i = 1; ?>
			@foreach ($results as $item)
				@if ($weights[$item->question_id] == $item->weight)
				<tr class="success">
				@elseif ($item->weight == 0)
				<tr class="danger">
				@else
				<tr>
				@endif
					<td><?php echo $i++; ?></td>
					<td>{{ $item->q_text }}</td>
					<td>{{ $item->a_text }}</td>
					<td>{{ $item->weight }}</td>
					<td>{{ $weights[$item->question_id] }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
@stop
