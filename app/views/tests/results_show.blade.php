@extends('layout.tests')

@section('title')
<div class="page-header">
	<h1>Просмотр результатов {{ $test->name }} - {{ $test->version }}</h1>
</div>
@stop

@section('menu')

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

{{ $token->firstName }} {{ $token->lastName }}

<p>Результат {{ $score }}</p>
<p>Максимальное количество баллов {{ $total_weight }}</p>
<p>Всего вопросов {{ $total_questions }}</p>
<p>Всего ответов {{ count($results) }}</p>

<table class="table">
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
	<tr>
		<td><?php echo $i++; ?></td>
		<td>{{ $item->q_text }}</td>
		<td>{{ $item->a_text }}</td>
		<td>{{ $item->weight }}</td>
		<td>{{ $weights[$item->question_id] }}</td>

	</tr>
	@endforeach
	</tbody>
</table>
@stop
