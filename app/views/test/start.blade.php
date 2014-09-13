@extends('layout.groups')

@section('title')
	<div class="page-header">
		<h1>Начало тестирования</h1>
	</div>
@stop

@section('menu')
@stop

@section('content')
	<div class="row">
		<div class="col-md-4">
			{{ Form::model($token, array('route' => array('start.store'), 'autocomplete' => 'off')) }}

			@if ($errors->any())
			<div class="panel panel-danger">
				@if (Session::has('message'))
				<div class="panel-heading">{{ Session::get('message') }}</div>
				@else
			  	<div class="panel-heading">Ошибки</div>
			  	@endif
			  	<div class="panel-body">
					{{ implode('', $errors->all('<p class="text-danger">:message</p>')) }}
			  	</div>
			</div>
			@else
				@if (Session::has('message'))
				<div class="panel panel-info">
					<div class="panel-heading">Сообщение</div>
					<div class="panel-body">
						{{ Session::get('message') }}
					</div>
				</div>
				@endif
			@endif

			<div>
				<p>Название теста: {{ $token->test->name }}</p>
				<p>Описание теста: {{ $token->test->description }}</p>
				<p>Продолжительность теста: {{ $token->test->duration }}</p>
			</div>

			<div class="form-group">
				{{ Form::label('firstName', 'Ваше имя'); }}
				{{ Form::text('firstName', null, array('class' => 'form-control')) }}
			</div>

			<div class="form-group">
				{{ Form::label('lastName', 'Ваша фамилия'); }}
				{{ Form::text('lastName', null, array('class' => 'form-control')) }}
			</div>

			<div class="form-group">
				{{ Form::label('department_id', 'Департамент'); }}
				{{ Form::select('department_id', $departments, null, ['class' => 'form-control']) }}
			</div>

			<div class="form-group">
				{{ Form::label('group_id', 'Отдел'); }}
				{{ Form::select('group_id', $groups, null, ['class' => 'form-control']) }}
			</div>

			<hr />

			<div class="form-group">
				{{ Form::submit('Начать тестирование', array('class' => 'btn btn-success')) }}
			</div>
			{{ Form::close() }}
		</div>
	</div>
@stop
