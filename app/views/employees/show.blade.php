@extends('layout.employees')

@section('title')
	<div class="page-header">
		<h1>
			{{ $employee->firstName }} {{ $employee->lastName }}
		</h1>
	</div>
@stop

@section('menu')
	<div class="btn-group">
	  	<a class="btn btn-default" href="{{ URL::route('employees.index') }}">
	  		<span class="glyphicon glyphicon-share-alt"></span>
	    	Вернуться к списку
	  	</a>
	  	<a class="btn btn-primary" href="{{ URL::route('employees.edit', $employee->id) }}">
	  		<span class="glyphicon glyphicon-cog"></span>
	    	Редактировать
	  	</a>
	</div>
@stop

@section('content')
<div class="row">
	<div class="col-md-6">
		<table class="table">
			<tbody>
				<tr>
					<td>ID</td>
					<td>{{ $employee->id }}</td>
				</tr>
				<tr>
					<td>Отображать на карте</td>
					<td>
						@if ($employee->active)
							<p class="text-success">да</p>
						@else
							<p class="text-danger">нет</p>
						@endif
					</td>
				</tr>
				<tr>
					<td>Имя</td>
					<td>
						@if ($employee->firstName)
							{{ $employee->firstName }}
						@else
							—
						@endif
					</td>
				</tr>
				<tr>
					<td>Фамилия</td>
					<td>
						@if ($employee->lastName)
							{{ $employee->lastName }}
						@else
							—
						@endif
					</td>
				</tr>
				<tr>
					<td>Департамент</td>
					<td>{{ $employee->department }}</td>
				</tr>
				<tr>
					<td>Отдел</td>
					<td>{{ $employee->group }}</td>
				</tr>
				<tr>
					<td>Должность</td>
					<td><strong>{{ $employee->specialty }}</strong></td>
				</tr>
				<tr>
					<td>Телефон</td>
					<td>
						@if ($employee->mobile)
							{{ $employee->mobile }}
						@else
							—
						@endif
					</td>
				</tr>
				<tr>
					<td>Добавочный номер</td>
					<td>
						@if ($employee->phone)
							{{ $employee->phone }}
						@else
							—
						@endif
					</td>
				</tr>
				<tr>
					<td>Электронная почта</td>
					<td>
						@if ($employee->email)
							<a href="mailto:{{ $employee->email }}">{{ $employee->email }}</a>
						@else
							—
						@endif
					</td>
				</tr>
				<tr>
					<td>Skype</td>
					<td>
						@if ($employee->skype)
							<a href="skype:{{ $employee->skype }}?chat">{{ $employee->skype }}</a>
						@else
							—
						@endif
					</td>
				</tr>
				<tr>
					<td>Redmine</td>
					<td>
						@if ($employee->redmine)
							<a href="http://redmine.cityads.ru/users/{{ $employee->redmine }}" target="_blank">{{ $employee->redmine }}</a>
						@else
							—
						@endif
					</td>
				</tr>
				<tr>
					<td>Fortnet</td>
					<td>
						@if ($employee->fortnet)
							<a href="http://fortnet/slim/?person={{ $employee->fortnet }}" target="_blank">{{ $employee->fortnet }}</a>
						@else
							—
						@endif
					</td>
				</tr>
				<tr>
					<td>Обязанности</td>
					<td>
						@if ($employee->info)
							{{ $employee->info }}
						@else
							—
						@endif
					</td>
				</tr>
				<tr>
					<td>Координаты</td>
					<td>
						x: {{ $employee->cx }}<br />
						y: {{ $employee->cy }}<br />
						z: {{ $employee->cz }}
					</td>
				</tr>
				<tr>
					<td>Добавлен</td>
					<td>{{ $employee->created_at }}</td>
				</tr>
				<tr>
					<td>Обновлен</td>
					<td>{{ $employee->updated_at }}</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-md-6">
		@if ($employee->photo)
			<img src="{{ $employee->photo }}" alt="{{ $employee->firstName }} {{ $employee->lastName }}" />
		@else
			<br /><br />
			<p class="lead text-center">Нет фотографии.</p>
		@endif
	</div>
</div>
@stop