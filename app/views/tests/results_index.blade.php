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

<table class="table">
	<thead>
	<th>#</th>
	<th>Имя</th>
	<th>Департамент</th>
	<th>Отдел</th>
	<th>Результат</th>
	<th>Продолжительность</th>
	</thead> 
	<tbody>
	<?php $i = 1; ?>
	@foreach ($results as $item)
	<tr>
		<td><?php echo $i++; ?></td>
		<td><a href="{{ URL::route('result.show', ['id' => $test->id, 'rid' => $item->id]) }}">
			{{ $tokens[$item->token]->firstName }} {{ $tokens[$item->token]->lastName }}
			</a>
		</td>
		<td>{{ $tokens[$item->token]->dept_name }}</td>
		<td>{{ $tokens[$item->token]->group_name }}</td>
		<td>{{ $item->total_weight }}/{{ $total_weight }} (ответов {{ $item->answered }}/{{ $total_questions }})</td>
		<td>{{ $duration[$item->token] }}</td>

		<td></td>
	</tr>
	@endforeach
	</tbody>
</table>
@stop
