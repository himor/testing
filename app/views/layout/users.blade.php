@extends('layout.layout')

@section('wrap')
	<div class="content">
		@yield('content')
	</div>
@stop

@section('menu')
	<div class="btn-group">
	  	<a class="btn btn-primary" href="{{ URL::route('users.create') }}">
	    	<span class="glyphicon glyphicon-plus"></span> Добавить
	  	</a>
	</div>
@stop
