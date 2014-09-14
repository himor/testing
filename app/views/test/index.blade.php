@extends('layout.test')

@section('title')
<div class="page-header">
	<h1>{{ $token->test->name }}</h1>
</div>
@stop

@section('menu')
@stop

@section('content')

<p>
	<strong>
		{{ $question->text }}
	</strong>
</p>

<form method="post" action="{{ URL::route('test.store') }}">

@foreach ($answers as $answer)
<p>
	<input type="radio" name="answer" value="{{ $answer->hash }}">

	{{ $answer->text }} ({{ $answer->hash }})</p>
@endforeach

	<input type="submit">

</form>

@stop
