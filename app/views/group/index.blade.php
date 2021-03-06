@extends('layout.groups')

@section('title')
	<div class="page-header">
		<h1>Отделы</h1>
	</div>
@stop

@section('menu')
	<div class="btn-group">
	  	<a class="btn btn-primary" href="{{ URL::route('groups.create') }}">
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
			<th>Добавлен</th>
			<th>Действие</th>
		</thead>
		<tbody>
			<?php $i = 1; ?>
			@foreach ($groups as $item)
				<tr>
					<td><?php echo $i++; ?></td>
					<td>{{ $item->name }}</td>
					<td>@if ($item->created_at->format('U') > 0) {{ $item->created_at->format('d.m.Y H:i:s') }} @endif</td>
					<td>
						<a href="{{ URL::route('groups.edit', $item->id) }}" class="btn btn-default btn-xs">
							<span class="glyphicon glyphicon-cog"></span>
							Редактировать
						</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop
