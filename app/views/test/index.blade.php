@extends('layout.test')

@section('title')
@stop

@section('menu')
@stop

@section('content')
<div class="page-header">
	<h1>{{ $token->test->name }}</h1>
	<div id="time"></div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			<strong>{{ $question->text }}</strong>&nbsp;|&nbsp;Вопрос {{ $answered + 1 }}/{{ $total }}
		</h3>
	</div>
	<div class="panel-body">
		<form method="post" action="{{ URL::route('test.store') }}">
			@if ($question->type == Question::TYPE_RADIO)
				@foreach ($answers as $answer)
				<p>
					<input type="radio" name="answer" value="{{ $answer->hash }}">
					{{ $answer->text }}
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
					{{ $answer->text }}
				</p>
				@endforeach
			@endif
			<hr />
			<input type="submit" class="btn btn-success" />
		</form>
	</div>
</div>
<script type="text/javascript">
	var path = "{{ URL::route('check_status') }}";
</script>
@stop
