@extends('layout.groups')

@section('title')
	<div class="page-header">
		<h1>Добавление отдела</h1>
	</div>
@stop

@section('menu')
	<div class="btn-group">
	  	<a class="btn btn-default" href="{{ URL::route('groups.index') }}">
	  		<span class="glyphicon glyphicon-share-alt"></span>
	    	Вернуться к списку
	  	</a>
	</div>
@stop

@section('content')
	<div class="row">
		<div class="col-md-4">
			{{ Form::model($group, array('route' => array('groups.store'), 'autocomplete' => 'off')) }}

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
				{{ Form::label('name', 'Название отдела'); }}
				{{ Form::text('name', null, array('class' => 'form-control')) }}
			</div>

			<hr />

			<div class="form-group">
				{{ Form::submit('Добавить', array('class' => 'btn btn-success')) }}
			</div>
			{{ Form::close() }}
		</div>
	</div>
@stop
