@extends('layout.layout')

@section('wrap')
<div class="content">
	@yield('content')
</div>
@stop

@section('menu')
<a href="{{ URL::route('tests.index') }}">index</a>
<a href="{{ URL::route('tests.create') }}">add</a>
@stop
