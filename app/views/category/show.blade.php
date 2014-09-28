@extends('layout.categories')

@section('content')

	<h3>Категория</h3>

	<p>Просмотр категории теста</p>

	<span>ID {{ $category->id }}</span>
	<span>Name {{ $category->name }}</span>
	<span>Created {{ $category->created_at }}</span>
	<span>Updated {{ $category->updated_at }}</span>

	<p><a href="{{ URL::route('categories.edit', $category->id) }}">edit</a></p>


@stop
