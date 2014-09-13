@extends('layout.layout')

@section('wrap')
<div class="content">

	@if (Session::has('message'))
	<div class="alert">
		<p>{{ Session::get('message') }}</p>
	</div>
	@endif

</div>
@stop
