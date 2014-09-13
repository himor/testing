@extends('layout.users')

@section('title')
	<div class="page-header">
		<h1>Пользователи <small>доступ к этой панели</small></h1>
	</div>
@stop

@section('content')
	@if (Session::has('error'))
	<div class="error">
		<p>{{ Session::get('error') }}</p>
	</div>
	@endif

	<table class="table">
		<thead>
			<th>#</th>
			<th>Электронная почта</th>
			<th>Имя</th>
			<th>Статус</th>
			<th>Добавлен</th>
			<th>Действие</th>
		</thead>
		<tbody>
			<?php $i = 1; ?>
			@foreach ($users as $user)
				<tr>
					<td><?php echo $i++; ?></td>
					<td class="long">{{ $user->email }}</td>
					<td>{{ $user->name }}</td>
					<td>
						@if (!$user->blocked) 
							<span class="label label-success">Активен</span> 
						@else 
							<span class="label label-danger">Заблокирован</span>
						@endif
					</td>
					<td>@if ($user->created_at->format('U') > 0) {{ $user->created_at->format('Y-m-d H:i:s') }} @endif</td>
					<td>
						<a href="{{ URL::route('users.edit', $user->id) }}" class="btn btn-default btn-xs">
							<span class="glyphicon glyphicon-cog"></span>
							Редактировать
						</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop
