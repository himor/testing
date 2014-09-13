@extends('layout.employees')

@section('title')
	<div class="page-header">
		<h1>Сотрудники</h1>
	</div>
@stop

@section('menu')
	<div class="btn-group">
	  	<a class="btn btn-primary" href="{{ URL::route('employees.create') }}">
	  		<span class="glyphicon glyphicon-plus"></span>
	    	Добавить
	  	</a>
	</div>
@stop

@section('content')
	@if (Session::has('error'))
	<div class="error">
		<p>{{ Session::get('error') }}</p>
	</div>
	@endif

	@if (Session::has('info'))
		<div class="alert alert-info" role="alert">{{ Session::get('info') }}</div>
	@endif

	<table class="table">
		<thead>
			<th>#</th>
			<th>Имя</th>
			<th>Фамилия</th>
			<th>Фото</th>
			<th>Почта</th>
			<th>Skype</th>
			<th>Добавочный</th>
			<th>Телефон</th>
			<th>Redmine</th>
			<th>Описание</th>
			<th>Действие</th>
		</thead>
		<tbody>
			<?php $i = 1; ?>
			@foreach ($employees as $item)
				@if ($item->active)
				<tr>
				@else
				<tr class="warning">
				@endif
					<td><?php echo $i++; ?></td>
					<td>
						@if ($item->firstName)
							{{ $item->firstName }}
						@else
							—
						@endif
					</td>
					<td>
						@if ($item->lastName)
							{{ $item->lastName }}
						@else
							—
						@endif
					</td>
					<td>
						@if ($item->photo)
						<button data-photo="{{ $item->photo }}" data-username="{{ $item->firstName }} {{ $item->lastName }}" class="btn btn-default btn-xs" data-toggle="modal" data-target="#userPhoto">
						  	<span class="glyphicon glyphicon-picture"></span>
						</button>
						@else
							—
						@endif
					</td>
					<td>
						@if ($item->email)
							<a href="mailto:{{ $item->email }}">{{ $item->email }}</a>
						@else
							—
						@endif
					</td>
					<td>
						@if ($item->skype)
							<a href="skype:{{ $item->skype }}?chat">{{ $item->skype }}</a>
						@else
							—
						@endif
					</td>
					<td>
						@if ($item->phone)
							{{ $item->phone }}
						@else
							—
						@endif
					</td>
					<td>
						@if ($item->mobile)
							{{ $item->mobile }}
						@else
							—
						@endif
					</td>
					<td>
						@if ($item->redmine)
							<a href="http://redmine.cityads.ru/users/{{ $item->redmine }}" target="_blank">{{ $item->redmine }}</a>
						@else
							—
						@endif
					</td>
					<td>
						@if ($item->info)
							+
						@else
							—
						@endif
					</td>
					<td>
						<a href="{{ URL::route('employees.show', $item->id) }}" class="btn btn-default btn-xs">
							<span class="glyphicon glyphicon-eye-open"></span>
						</a>
						<a href="{{ URL::route('employees.edit', $item->id) }}" class="btn btn-primary btn-xs">
							<span class="glyphicon glyphicon-cog"></span>
						</a>
						@if ($item->active)
						<a href="{{ URL::route('base', array('user' => $item->id)) }}" class="btn btn-default btn-xs">
							<span class="glyphicon glyphicon-map-marker"></span>
						</a>
						@endif
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

<!-- Modal -->
<div class="modal fade" id="userPhoto" tabindex="-1" role="dialog" aria-labelledby="userPhotoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="userPhotoLabel">Modal title</h4>
      </div>
      <div class="modal-body" id="userPhotoNode">
      	<img src="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
@stop