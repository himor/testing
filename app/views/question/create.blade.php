@extends('layout.tests')

@section('title')
	<div class="page-header">
		<h1>Новый вопрос #{{ $question->number }} к тесту
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
	{{ Form::model($question, array('route' => array('question.store'), 'autocomplete' => 'off')) }}
		<div class="row">
			<div class="col-md-12">
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
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				{{ Form::hidden('test_id'); }}
				{{ Form::hidden('number'); }}
				<div class="form-group">
					{{ Form::label('text', 'Текст вопроса:'); }}
					{{ Form::textarea('text', null, array('class' => 'form-control')) }}
				</div>
				<div class="form-group">
					{{ Form::label('type', 'Тип вопроса'); }}
					<div class="radio">
						<label>{{ Form::radio('type', Question::TYPE_RADIO, true, array('class' => '_answer_type')) }} Простой переключатель</label>
					</div>
					<div class="radio">
						<label>{{ Form::radio('type', Question::TYPE_CHECKBOX, false, array('class' => '_answer_type')) }} Несколько возможных ответов</label>
					</div>
					<div class="radio">
						<label>{{ Form::radio('type', Question::TYPE_STRING, false, array('class' => '_answer_type')) }} Текстовый ответ</label>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<h4>Варианты ответа: <button type="button" class="btn btn-primary btn-xs" id="add_answer">Добавить</button></h4>
				<hr />
				<div class="form-group" id="answers"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{{ Form::hidden('number_of_answers', false, array('id' => 'number_of_answers')); }}
				<hr />
				<div class="form-group">
					{{ Form::submit('Сохранить', array('class' => 'btn btn-success _submit')) }}
				</div>
			</div>
		</div>
		@include('question.answers')
	{{ Form::close() }}
@stop
