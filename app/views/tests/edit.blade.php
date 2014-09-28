@extends('layout.groups')

@section('title')
<div class="page-header">
	<h1>
		{{ $test->name }}
		<small>редактирование теста</small>
	</h1>
</div>
@stop

@section('menu')
{{ Form::model($test, [
'route'        => ['tests.destroy', $test->id],
'autocomplete' => 'off',
'method'      => 'delete'
]) }}
<div class="btn-group">
	<a class="btn btn-default" href="{{ URL::route('tests.index') }}">
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
		{{ Form::model($test, [
		'route' => ['tests.update', $test->id],
		'autocomplete' => 'off',
		'method' => 'put'
		]) }}

		@if ($errors->any())
		<div class="panel panel-danger">
			@if (Session::has('message'))
			<div class="panel-heading">{{ Session::get('message') }}</div>
			@else
			<div class="panel-heading">Ошибки</div>
			@endif
			<div class="panel-body">
				{{ implode('', $errors->all('<p class="text-danger">:message</p>
				')) }}
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
			{{ Form::label('name', 'Название теста'); }}
			{{ Form::text('name', null, array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('version', 'Версия'); }}
			{{ Form::text('version', null, array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('description', 'Описание'); }}
			{{ Form::text('description', null, array('class' => 'form-control'))
			}}
		</div>

		<div class="form-group">
			{{ Form::label('category_id', 'Укажите категорию теста'); }}
			{{ Form::select('category_id', $categories, null, ['class' =>
			'form-control']) }}
		</div>

		<div class="form-group">
			{{ Form::label('duration', 'Продолжительность'); }}
			{{ Form::text('duration', null, array('class' => 'form-control')) }}
		</div>

		@if ($results == 0)
		<div class="form-group">
			{{ Form::label('type', 'Тип теста'); }}
			<div class="radio">
				<label>
					{{ Form::radio('type', Test::TEST_TYPE_SUMMA, true) }} Суммировать баллы в зависимости от ответов на вопросы
				</label>
			</div>
			<div class="radio">
				<label>
					{{ Form::radio('type', Test::TEST_TYPE_PSYCHO, false) }} «Тест принадлежности»
				</label>
			</div>
		</div>
		@endif

		<div class="form-group">
			{{ Form::checkbox('active', '1', false) }} Открыт для тестирования
		</div>

		<hr/>
		<div class="form-group">
			{{ Form::submit('Обновить', array('class' => 'btn btn-success')) }}
		</div>

		{{ Form::close() }}
	</div>
</div>
@stop
