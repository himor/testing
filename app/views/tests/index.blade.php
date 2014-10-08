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
		<div class="alert alert-danger" role="alert">{{ Session::get('error') }}</div>
	@endif

	@if (Session::has('info'))
		<div class="alert alert-info" role="alert">{{ Session::get('info') }}</div>
	@endif

	<table class="table">
		<thead>
			<th>#</th>
			<th>Название</th>
			<th>Версия</th>
			<th>Статус</th>
			<th>Категория</th>
			<th>Действие</th>
		</thead>
		<tbody>
			<?php $i = 1; ?>
			@foreach ($tests as $item)
				<tr>
					<td>{{ $i++ }}</td>
					<td><a href="{{ URL::route('tests.show', $item->id) }}">{{ $item->name }}</a></td>
					<td>{{ $item->version }}</td>
					<td>
						@if (!$item->active) 
							<span class="label label-success">Открыт</span> 
						@else 
							<span class="label label-danger">Закрыт</span>
						@endif
					</td>
					<td>{{ $item->category->name }}</td>
					<td>
						<a href="{{ URL::route('tests.show', $item->id) }}" class="btn btn-default btn-xs">
							<span class="glyphicon glyphicon-eye-open"></span>
						</a>
						<a href="{{ URL::route('tests.edit', $item->id) }}" class="btn btn-default btn-xs">
							<span class="glyphicon glyphicon-cog"></span>
						</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop
