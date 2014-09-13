@extends('layout.security')

@section('title')
	<h1 class="text-center">
		Авторизация
	</h1>
@stop

@section('content')
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		{{ Form::open(array('route' => 'login.post', 'class' => 'form-horizontal')) }}

		<div class="form-group">

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
		@endif

		</div>

			<div class="form-group">
				{{ Form::label('email', 'Электронная почта'); }}
				{{ Form::text('email', null, array('class' => 'form-control')) }}
			</div>

			<div class="form-group">
				{{ Form::label('password', 'Пароль'); }}
				{{ Form::password('password', array('class' => 'form-control')) }}
			</div>


			<div class="form-group">
				{{ Form::submit('Войти', array('class' => 'btn btn-success btn-lg')) }}
			</div>

			{{ Form::close() }}
		</div>
	</div>
	@stop
@stop