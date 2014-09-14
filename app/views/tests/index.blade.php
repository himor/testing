@extends('layout.tests')

@section('title')
	<div class="page-header">
		<h1>Тесты</h1>
	</div>
@stop

@section('menu')
	<div class="btn-group">
	  	<a class="btn btn-primary" href="{{ URL::route('tests.create') }}">
	  		<span class="glyphicon glyphicon-plus"></span>
	    	Добавить
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

	<table class="table">
		<thead>
			<th>#</th>
			<th>Название</th>
			<th>Версия</th>
			<th>Категория</th>
			<th>Действие</th>
		</thead>
		<tbody>
			<?php $i = 1; ?>
			@foreach ($tests as $item)
				<tr>
					<td><?php echo $i++; ?></td>
					<td>{{ $item->name }}</td>
					<td>{{ $item->version }}</td>
					<td>{{ $item->category->name }}</td>

					<td>

					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop
