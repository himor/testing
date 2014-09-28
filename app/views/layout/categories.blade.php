@extends('layout.layout')

@section('wrap')
<div class="content">
	@yield('content')
</div>
@stop

@section('menu')
<a href="{{ URL::route('categories.index') }}">index</a>
<a href="{{ URL::route('categories.create') }}">add</a>
@stop
