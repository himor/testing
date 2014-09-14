@extends('layout.tests')

@section('content')

<h3>Тест</h3>

<p>Просмотр теста</p>

<span>ID {{ $test->id }}</span>
<span>Name {{ $test->name }}</span>
<span>Description {{ $test->description }}</span>
<span>Duration {{ $test->duration }}</span>
<span>Category {{ $test->category->name }}</span>
<span>Type {{ $test->type }}</span>

<span>Created {{ $test->created_at }}</span>
<span>Updated {{ $test->updated_at }}</span>

<p><a href="{{ URL::route('tests.edit', $test->id) }}">Редактировать</a></p>
<p><a href="{{ URL::route('version.create', $test->id) }}">Создать новую версию</a></p>


<p><a href="{{ URL::route('token.create', $test->id) }}" target="_blank">Отправить пользователю</a></p>

@if ($results == 0)
<p><a href="{{ URL::route('question.create', $test->id) }}">Добавить вопрос</a></p>
@else
<p><a href="{{ URL::route('result.index', $test->id) }}">Отобразить результаты</a></p>
@endif

@stop
