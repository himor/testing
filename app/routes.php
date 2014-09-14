<?php

Route::pattern('id', '[0-9]+');
Route::pattern('token', '[0-9a-z]+');
Route::get('/', [
		'as'   => 'base',
		'uses' => 'HomeController@defaultAction'
	]
);

Route::get('info', [
		'as'   => 'info',
		'uses' => 'HomeController@infoAction'
	]
);

/**
 * Administering
 */
Route::when('admin/*', 'auth');
Route::get('admin', [
		'as'     => 'admin',
		'before' => 'auth',
		'uses'   => 'AdminController@defaultAction'
	]
);

/**
 * Administering users
 */
Route::get('admin/users', [
		'as'   => 'users.index',
		'uses' => 'UserController@indexAction'
	]
);
Route::get('admin/users/create', [
		'as'   => 'users.create',
		'uses' => 'UserController@createAction'
	]
);
Route::post('admin/users', [
		'as'     => 'users.store',
		'before' => 'csrf',
		'uses'   => 'UserController@storeAction'
	]
);
Route::get('admin/users/{id}', [
		'as'   => 'users.show',
		'uses' => 'UserController@showAction'
	]
);
Route::get('admin/users/{id}/edit', [
		'as'   => 'users.edit',
		'uses' => 'UserController@editAction'
	]
);
Route::put('admin/users/{id}', [
		'as'     => 'users.update',
		'before' => 'csrf',
		'uses'   => 'UserController@updateAction'
	]
);
Route::delete('admin/users/{id}', [
		'as'   => 'users.destroy',
		'uses' => 'UserController@deleteAction'
	]
);

/**
 * Authentication
 */
Route::get('/login', [
		'as'   => 'login.get',
		'uses' => 'SecurityController@loginAction'
	]
);
Route::post('/login', [
		'as'     => 'login.post',
		'before' => 'csrf',
		'uses'   => 'SecurityController@loginAttempt'
	]
);
Route::get('/logout', [
		'as'   => 'logout',
		'uses' => 'SecurityController@logoutAction'
	]
);

/**
 * Departments
 */
Route::get('admin/departments', [
		'as'   => 'departments.index',
		'uses' => 'DepartmentController@indexAction'
	]
);
Route::get('admin/departments/create', [
		'as'   => 'departments.create',
		'uses' => 'DepartmentController@createAction'
	]
);
Route::post('admin/departments', [
		'as'     => 'departments.store',
		'before' => 'csrf',
		'uses'   => 'DepartmentController@storeAction'
	]
);
Route::get('admin/departments/{id}', [
		'as'   => 'departments.show',
		'uses' => 'DepartmentController@showAction'
	]
);
Route::get('admin/departments/{id}/edit', [
		'as'   => 'departments.edit',
		'uses' => 'DepartmentController@editAction'
	]
);
Route::put('admin/departments/{id}', [
		'as'     => 'departments.update',
		'before' => 'csrf',
		'uses'   => 'DepartmentController@updateAction'
	]
);
Route::delete('admin/departments/{id}', [
		'as'   => 'departments.destroy',
		'uses' => 'DepartmentController@deleteAction'
	]
);

/**
 * Groups
 */
Route::get('admin/groups', [
		'as'   => 'groups.index',
		'uses' => 'GroupController@indexAction'
	]
);
Route::get('admin/groups/create', [
		'as'   => 'groups.create',
		'uses' => 'GroupController@createAction'
	]
);
Route::post('admin/groups', [
		'as'     => 'groups.store',
		'before' => 'csrf',
		'uses'   => 'GroupController@storeAction'
	]
);
Route::get('admin/groups/{id}', [
		'as'   => 'groups.show',
		'uses' => 'GroupController@showAction'
	]
);
Route::get('admin/groups/{id}/edit', [
		'as'   => 'groups.edit',
		'uses' => 'GroupController@editAction'
	]
);
Route::put('admin/groups/{id}', [
		'as'     => 'groups.update',
		'before' => 'csrf',
		'uses'   => 'GroupController@updateAction'
	]
);
Route::delete('admin/groups/{id}', [
		'as'   => 'groups.destroy',
		'uses' => 'GroupController@deleteAction'
	]
);

/**
 * Test creation
 */
Route::get('admin/tests', [
		'as'   => 'tests.index',
		'uses' => 'TestsController@indexAction'
	]
);
Route::get('admin/tests/create', [
		'as'   => 'tests.create',
		'uses' => 'TestsController@createAction'
	]
);
Route::post('admin/tests', [
		'as'     => 'tests.store',
		'before' => 'csrf',
		'uses'   => 'TestsController@storeAction'
	]
);
Route::get('admin/tests/{id}', [
		'as'   => 'tests.show',
		'uses' => 'TestsController@showAction'
	]
);
Route::get('admin/tests/{id}/edit', [
		'as'   => 'tests.edit',
		'uses' => 'TestsController@editAction'
	]
);
Route::put('admin/tests/{id}', [
		'as'     => 'tests.update',
		'before' => 'csrf',
		'uses'   => 'TestsController@updateAction'
	]
);
Route::delete('admin/tests/{id}', [
		'as'   => 'tests.destroy',
		'uses' => 'TestsController@deleteAction'
	]
);

/**
 * Question creation
 */



/**
 * Token initialization
 */
Route::get('/start', [
		'as'   => 'start.index',
		'uses' => 'TokenController@startIndexAction'
	]
);

Route::post('/start', [
		'as'   => 'start.store',
		'uses' => 'TokenController@startAction'
	]
);

/**
 * Testing
 */
Route::get('/test', [
		'as'   => 'test.index',
		'uses' => 'TestController@indexAction'
	]
);

Route::post('/test', [
		'as'   => 'test.store',
		'uses' => 'TestController@storeAction'
	]
);

Route::get('/test/check_status', [
		'as'   => 'check_status',
		'uses' => 'TestController@checkTime'
	]
);

/**
 * Tokens
 */
Route::get('/{token}', [
		'as'   => 'token.index',
		'uses' => 'TokenController@indexAction'
	]
);
