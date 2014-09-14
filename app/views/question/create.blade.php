@extends('layout.tests')

@section('title')
	<div class="page-header">
		<h1>Новый вопрос к тесту
		<small>{{ $test->name }}</small>
		</h1>
	</div>
@stop

@section('menu')
	<div class="btn-group">
	  	<a class="btn btn-default" href="{{ URL::route('tests.show', ['id' => $test->id]) }}">
	  		<span class="glyphicon glyphicon-share-alt"></span>
	    	Вернуться к списку
	  	</a>
	</div>
@stop

@section('content')
	<div class="row">
		<div class="col-md-4">
			{{ Form::model($question, array('route' => array('question.store'), 'autocomplete' => 'off')) }}

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

			{{ Form::hidden('test_id'); }}

			<div class="form-group">
				{{ Form::label('text', 'Текст вопроса:'); }}
				{{ Form::text('text', null, array('class' => 'form-control')) }}
			</div>

			<div class="form-group">
				{{ Form::label('type', 'Тип вопроса'); }}
				{{ Form::radio('type', Question::TYPE_RADIO, true) }} Простой переключатель
				{{ Form::radio('type', Question::TYPE_CHECKBOX, false) }} Несколько возможных ответов
				{{ Form::radio('type', Question::TYPE_STRING, false) }} Текстовый ответ
			</div>

			<hr />

			<div>

				<input type="hidden" name="number_of_answers" value="2" />

				<p>Варианты ответа</p>

				<div class="form-group">
					<label>Текст ответа</label>
					<input type="text" name="a_1_text" value="" />
				</div>

				<div class="form-group">
					<label>Вес ответа</label>
					<input type="text" name="a_1_weight" value="0" />
				</div>

				<div class="form-group">
					<label>Правильный ответ</label>
					<input type="checkbox" name="a_1_correct" value="1" />
				</div>

			</div>

			<div class="form-group">
				{{ Form::submit('Сохранить', array('class' => 'btn btn-success')) }}
			</div>
			{{ Form::close() }}
		</div>
	</div>
@stop
