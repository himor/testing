@extends('layout.tests')

@section('title')
	<div class="page-header">
		<h1>
			{{ $test->name }}
		</h1>
	</div>
@stop

@section('menu')
	<div class="btn-group">
	  	<a class="btn btn-default" href="{{ URL::route('tests.index') }}">
	  		<span class="glyphicon glyphicon-share-alt"></span>
	    	Вернуться к списку
	  	</a>
	  	@if (Auth::id() == $test->user_id && $results == 0)
	  	<a class="btn btn-primary" href="{{ URL::route('tests.edit', $test->id) }}">
	  		<span class="glyphicon glyphicon-cog"></span>
	    	Редактировать
	  	</a>
	  	@endif
	</div>
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered">
				<tbody>
					<tr>
						<td>ID</td>
						<td>{{ $test->id }}</td>
					</tr>
					<tr>
						<td>Название</td>
						<td><strong>{{ $test->name }}</strong></td>
					</tr>
					<tr>
						<td>Описание</td>
						<td>{{ $test->description }}</td>
					</tr>
					<tr>
						<td>Продолжительность</td>
						<td>{{ $test->duration }}</td>
					</tr>
					<tr>
						<td>Категория</td>
						<td>{{ $test->category->name }}</td>
					</tr>
					<tr>
						<td>Тип</td>
						<td>
							@if ($test->type == 1)
							Сумма баллов
							@endif 

							@if ($test->type == 2)
							Психологический
							@endif 
						</td>
					</tr>
					<tr>
						<td>Создан</td>
						<td>{{ $test->created_at }}</td>
					</tr>
					<tr>
						<td>Обновлен</td>
						<td>{{ $test->updated_at }}</td>
					</tr>
				</tbody>
			</table>
			<hr />
			<?php $n = 1; ?>
			@if (count($test->questions) > 0)
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Номер</th>
							<th>Тип</th>
							<th>Текст</th>
							<th>Ответы</th>
							@if (Auth::id() == $test->user_id && $results == 0)
							<th>Действие</th>
							@endif
						</tr>
					</thead>
					<tbody>
						@foreach ($test->questions as $question)
							<tr>
								<td>{{ $n++ }}</td>
								<td> 
									@if ($question->type == 1)
									Единственный выбор
									@elseif ($question->type == 2)
									Множественный выбор
									@else
									Текстовый ответ
									@endif 
								</td>
								<td>{{ $question->text }}</td>
								<td>
									<?php $j = 1; ?>
									@if (count($question->answers) > 0)
										<table class="table table-condensed">
											<thead>
												<tr>
													<th>#</th>
													<th>Текст ответа</th>
													<th width="80">Вес</th>
													<th width="100">Правильность</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($question->answers as $answer)
													<tr>
														<td>{{ $j++ }}</td>
														<td>{{ $answer->text }}</td>
														<td width="80">{{ $answer->weight }}</td>
														@if ($answer->is_correct)
														<td class="success" width="100">Правильный</td>
														@else
														<td class="danger" width="100">Неправильный</td>
														@endif
													</tr>
												@endforeach
											</tbody>
										</table>
									@else 
										@if ($question->type == 3)
											—
										@else
											К данному вопросу не указаны ответы.
										@endif										
									@endif
								</td>
								@if (Auth::id() == $test->user_id && $results == 0)
								<td>
									{{ Form::model($question, [
										'route'        => ['question.destroy', $question->id],
										'autocomplete' => 'off',
										'method'       => 'delete'
									]) }}
										<div class="btn-group-vertical">
											<a class="btn btn-default" href="{{ URL::route('question.edit', $question->id) }}">
										  		<span class="glyphicon glyphicon-pencil"></span>
										    	Редактировать
										  	</a>
											{{ Form::submit('Удалить', array('class' => 'btn btn-danger')) }}
										</div>
									{{ Form::close() }}		
								</td>
								@endif
							</tr>
						@endforeach
					</tbody>
				</table>
			@else 
				<p>В данном тесте пока нет вопросов.</p>
			@endif
			<hr />
			<div class="btn-group">
				<a class="btn btn-success" href="{{ URL::route('token.create', $test->id) }}">
			  		<span class="glyphicon glyphicon-envelope"></span>
			    	Отправить пользователю
			  	</a>
			  	<a class="btn btn-default" href="{{ URL::route('version.create', $test->id) }}">
			  		<span class="glyphicon glyphicon-pushpin"></span>
			    	Создать новую версию
			  	</a>
			  	@if (Auth::id() == $test->user_id)
				  	@if ($results == 0)
						<a class="btn btn-default" href="{{ URL::route('question.create', $test->id) }}">
					  		<span class="glyphicon glyphicon-question-sign"></span>
					    	Добавить вопрос
					  	</a>
				  	@else
					<a class="btn btn-default" href="{{ URL::route('result.index', $test->id) }}">
				  		<span class="glyphicon glyphicon-eye-open"></span>
				    	Отобразить результаты
				  	</a>
				  	@endif
				@endif
			</div>
		</div>
	</div>
@stop
