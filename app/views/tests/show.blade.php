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

<p><a href="{{ URL::route('tests.edit', $test->id) }}">edit</a></p>

<p><a href="#">добавить вопрос</a></p>

@stop
