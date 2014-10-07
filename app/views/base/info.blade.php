@extends('layout.layout')

@section('wrap')
<div class="content">

	@if (Session::has('message'))
	<div class="alert">
		<p>{{ Session::get('message') }}</p>
		<hr />
		<a href="{{ URL::route('test.index') }}" class="btn btn-primary">Продолжить</a>
	</div>
	@endif

</div>
@stop
