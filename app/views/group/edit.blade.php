@extends('layout.groups')

@section('title')
	<div class="page-header">
		<h1>
			{{ $group->name }}
			<small>редактирование отдела</small>
		</h1>
	</div>
@stop

@section('menu')
	{{ Form::model($group, [
		'route'        => ['groups.destroy', $group->id],
		'autocomplete' => 'off',
		'method'      => 'delete'
	]) }}
	<div class="btn-group">
	  	<a class="btn btn-default" href="{{ URL::route('groups.index') }}">
	  		<span class="glyphicon glyphicon-share-alt"></span>
	    	Вернуться к списку
	  	</a>
	  	{{ Form::submit('Удалить', array('class' => 'btn btn-danger')); }}
	</div>
	{{ Form::close() }}
@stop

@section('content')
<div class="row">
	<div class="col-md-6">
	{{ Form::model($group, [
		'route'        => ['groups.update', $group->id],
		'autocomplete' => 'off',
		'method'       => 'put'
		]) }}

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

	<div class="form-group">
		{{ Form::label('name', 'Название отдела'); }}
		{{ Form::text('name', null, array('class' => 'form-control')) }}
	</div>
	
	<hr />
	<div class="form-group">
		{{ Form::submit('Обновить', array('class' => 'btn btn-success')) }}
	</div>

	{{ Form::close() }}
	</div>
</div>
@stop
