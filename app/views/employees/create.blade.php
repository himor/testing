@extends('layout.employees')

@section('title')
	<div class="page-header">
		<h1>
			Добавление сотрудника
		</h1>
	</div>
@stop

@section('menu')
	<div class="btn-group">
	  	<a class="btn btn-default" href="{{ URL::route('employees.index') }}">
	  		<span class="glyphicon glyphicon-share-alt"></span>
	    	Вернуться к списку
	  	</a>
	</div>
@stop

@section('content')
<div class="row">
	<div class="col-md-12">
		<div id="map"></div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		{{ Form::model($employee, array('route' => array('employees.store'), 'autocomplete' => 'off', 'files' => true)) }}

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
			{{ Form::label('firstName', 'Имя') }}
			{{ Form::text('firstName', null, array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('lastName', 'Фамилия'); }}
			{{ Form::text('lastName', null, array('class' => 'form-control')) }}
		</div>

		<div class="checkbox">
		    <label>
		    	{{ Form::checkbox('active', null); }} Отображать на карте
		    </label>
		</div>

		<hr />

		<div class="form-group">
			{{ Form::label('email', 'Электронная почта'); }}
			{{ Form::text('email', null, array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('phone', 'Добавочный номер'); }}
			{{ Form::text('phone', null, array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('mobile', 'Мобильный телефон'); }}
			{{ Form::text('mobile', null, array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('skype', 'Skype'); }}
			{{ Form::text('skype', null, array('class' => 'form-control')) }}
		</div>

		<hr />

		<div class="form-group">
			{{ Form::label('info', 'Обязанности'); }}
			{{ Form::textarea('info', null, array('class' => 'form-control', 'rows' => 5)) }}
		</div>	

		<hr />

		<div class="form-group">
			{{ Form::label('redmine', 'Redmine ID'); }}
			{{ Form::text('redmine', null, array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('fortnet', 'Fortnet ID'); }}
			{{ Form::text('fortnet', null, array('class' => 'form-control')) }}
		</div>

		<hr />

		<div class="form-group">
			{{ Form::label('department_id', 'Департамент'); }}
			{{ Form::select('department_id', $departments, null, ['class' => 'form-control']) }}	
		</div>

		<div class="form-group">
			{{ Form::label('group_id', 'Отдел'); }}
			{{ Form::select('group_id', $groups, null, ['class' => 'form-control']) }}	
		</div>

		<div class="form-group">
			{{ Form::label('specialty_id', 'Должности'); }}
			{{ Form::select('specialty_id', $specialties, null, ['class' => 'form-control']) }}	
		</div>

		<hr />

		<div class="row">
  			<div class="col-xs-4">
	    		{{ Form::label('cx', 'X'); }}
				{{ Form::text('cx', null, array('class' => 'form-control')) }}
		  	</div>
	 		<div class="col-xs-4">
	    		{{ Form::label('cy', 'Y'); }}
				{{ Form::text('cy', null, array('class' => 'form-control')) }}
	  		</div>
	  		<div class="col-xs-4">
	    		{{ Form::label('cz', 'Z'); }}
				{{ Form::text('cz', 0, array('class' => 'form-control', 'readonly' => true)) }}
	  		</div>
		</div>

		{{ Form::hidden('x', null, array('id' => 'x')); }}
		{{ Form::hidden('y', null, array('id' => 'y')); }}
		{{ Form::hidden('w', null, array('id' => 'w')); }}
		{{ Form::hidden('h', null, array('id' => 'h')); }}

		<hr />
			<div class="form-group">
				{{ Form::label('photo', 'Фотография'); }}
				{{ Form::file('photo', null, array('class' => 'form-control', 'id' => 'photo')) }}
			</div>
		<hr />

		<div class="form-group">
			{{ Form::submit('Добавить', array('class' => 'btn btn-success')) }}
		</div>

		@if (Session::has('message'))
		<div class="alert">
			<p>{{ Session::get('message') }}</p>
		</div>
		@endif

		{{ Form::close() }}
	</div>
	<div class="col-md-6">
		<img id="preview" class="crop">
	</div>
</div>
@stop