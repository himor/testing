<!doctype html>
<html class="no-js" lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <base href="<?php echo URL::to('/'); ?>">
        <title>Управление | Схема офиса CityAds</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <?php //echo Assets::css(); ?>
    </head>
    <body>
    	@if (Auth::check())
    	<header>
    		<div class="container">
    			<div class="row">
    				<div class="col-md-12">
						<nav class="navbar navbar-default" role="navigation">
					  		<div class="container-fluid">
							    <div class="navbar-header">
							      	<a class="navbar-brand" href="{{ URL::route('admin') }}">CityAds Map</a>
							    </div>
					    		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					      			<form class="navbar-form navbar-left" role="search">
					        			<div class="form-group" style="position: relative;">
					          				<input id="autocomplete" type="text" class="form-control" placeholder="Поиск сотрудника">
					        			</div>
					      			</form>
					      			<ul class="nav navbar-nav">
					        			@if (Route::currentRouteName() == 'employees.index')
					        			<li class="active">
					        			@else
					        			<li>
					        			@endif
					        				<a href="">Сотрудники</a>
					        			</li>
					        			@if (Route::currentRouteName() == 'users.index')
					        			<li class="active">
					        			@else
					        			<li>
					        			@endif
					        				<a href="{{ URL::route('users.index') }}">Пользователи</a>
					        			</li>
					        			<li class="dropdown">
					          				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Справочники <span class="caret"></span></a>
				          					<ul class="dropdown-menu" role="menu">
				          						<li><a href="{{ URL::route('departments.index') }}">Департаменты</a></li>
												<li><a href="{{ URL::route('groups.index') }}">Отделы</a></li>
				          					</ul>
					        			</li>
					      			</ul>
					      			<ul class="nav navbar-nav navbar-right">
					      				<li>
					      					<p class="navbar-text">Вы вошли как <strong>{{ Auth::user()->name }}</strong></p>
					      				</li>
					        			<li>
					        				<a href="{{ URL::route('logout') }}">Выйти</a>
					        			</li>
					      			</ul>
					    		</div>
					  		</div>
						</nav>
					</div>
				</div>
			</div>
    	</header>
    	@endif
    	<main>
    		<div class="container">
    			<div class="row">
    				<div class="col-md-12">
    					@yield('title')
    				</div>
    			</div>
    			<div class="row">
    				<div class="col-md-12">
    					@yield('menu')
    					<hr />
    				</div>
    			</div>
    		</div>
    		<div class="container">
    			<div class="row">
    				<div class="col-md-12">
    					@yield('wrap')
    				</div>
    			</div>
    		</div>
    	</main>
        <?php //echo Assets::js(); ?>
    </body>
</html>