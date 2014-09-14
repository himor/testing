@extends('layout.tests')

@section('title')
	<div class="page-header">
		<h1>Новая версия теста</h1>
	</div>
@stop

@section('menu')
	<div class="btn-group">
	  	<a class="btn btn-default" href="{{ URL::route('tests.index') }}">
	  		<span class="glyphicon glyphicon-share-alt"></span>
	    	Вернуться к списку
	  	</a>
	</div>
@stop

@section('content')
	<div class="row">
		<div class="col-md-4">
			{{ Form::model($test, array('route' => array('version.store'), 'autocomplete' => 'off')) }}

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

			{{ Form::hidden('id'); }}
			{{ Form::hidden('type'); }}

			<div class="form-group">
				{{ Form::label('name', 'Название теста'); }}
				{{ Form::text('name', null, array('class' => 'form-control')) }}
			</div>

			<div class="form-group">
				{{ Form::label('version', 'Версия'); }}
				{{ Form::text('version', null, array('class' => 'form-control')) }}
			</div>

			<div class="form-group">
				{{ Form::label('description', 'Описание'); }}
				{{ Form::text('description', null, array('class' => 'form-control')) }}
			</div>

			<div class="form-group">
				{{ Form::label('category_id', 'Укажите категорию теста'); }}
				{{ Form::select('category_id', $categories, null, ['class' => 'form-control']) }}
			</div>

			<div class="form-group">
				{{ Form::label('duration', 'Продолжительность'); }}
				{{ Form::text('duration', null, array('class' => 'form-control')) }}
			</div>

			<hr />

			<div class="form-group">
				{{ Form::submit('Создать', array('class' => 'btn btn-success')) }}
			</div>
			{{ Form::close() }}
		</div>
	</div>
@stop
