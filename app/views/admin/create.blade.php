@extends('layout.users')

@section('title')
	<div class="page-header">
		<h1>Добавление пользователя</h1>
	</div>
@stop

@section('menu')
	<div class="btn-group">
	  	<a class="btn btn-default" href="{{ URL::route('users.index') }}">
	  		<span class="glyphicon glyphicon-share-alt"></span>
	    	Вернуться к списку
	  	</a>
	</div>
@stop


@section('content')

<div class="row">
	<div class="col-md-4">
	{{ Form::model($user, array('route' => array('users.store'), 'autocomplete' => 'off')) }}
	
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

	<div class="form-group">
		{{ Form::label('name', 'Имя'); }}
		{{ Form::text('name', null, array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('email', 'Электронная почта'); }}
		{{ Form::text('email', null, array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('password', 'Пароль'); }} [<a href="https://www.random.org/passwords/?num=1&len=8&format=plain&rnd=new" target="_blank">рандомный пароль</a>]
		{{ Form::password('password', array('class' => 'form-control')) }}
	</div>

	<hr />

	<div class="form-group">
		{{ Form::submit('Добавить', array('class' => 'btn btn-success')) }}
	</div>

	{{ Form::close() }}

</div>
@stop
