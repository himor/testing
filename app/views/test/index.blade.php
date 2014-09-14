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

	@if ($question->type == Question::TYPE_RADIO)
	@foreach ($answers as $answer)
	<p>
		<input type="radio" name="answer" value="{{ $answer->hash }}">
		{{ $answer->text }} ({{ $answer->hash }})
	</p>
	@endforeach

	@elseif ($question->type == Question::TYPE_STRING)
	<p>
		<input type="test" name="answer" value="">
	</p>

	@elseif ($question->type == Question::TYPE_CHECKBOX)
	@foreach ($answers as $answer)
	<p>
		<input type="checkbox" name="answer[]" value="{{ $answer->hash }}">
		{{ $answer->text }} ({{ $answer->hash }})
	</p>
	@endforeach

	@endif



	<input type="submit">

</form>

@stop
