<?php

Route::pattern('id', '[0-9]+');
Route::pattern('rid', '[0-9]+');
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

Route::group(array('prefix' => 'admin'), function()
{
	Assets::reset()->add('admin');
});

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
 * Categories
 */
Route::get('admin/categories', [
		'as'   => 'categories.index',
		'uses' => 'CategoriesController@indexAction'
	]
);
Route::get('admin/categories/create', [
		'as'   => 'categories.create',
		'uses' => 'CategoriesController@createAction'
	]
);
Route::post('admin/categories', [
		'as'     => 'categories.store',
		'before' => 'csrf',
		'uses'   => 'CategoriesController@storeAction'
	]
);
Route::get('admin/categories/{id}', [
		'as'   => 'categories.show',
		'uses' => 'CategoriesController@showAction'
	]
);
Route::get('admin/categories/{id}/edit', [
		'as'   => 'categories.edit',
		'uses' => 'CategoriesController@editAction'
	]
);
Route::put('admin/categories/{id}', [
		'as'     => 'categories.update',
		'before' => 'csrf',
		'uses'   => 'CategoriesController@updateAction'
	]
);
Route::delete('admin/categories/{id}', [
		'as'   => 'categories.destroy',
		'uses' => 'CategoriesController@deleteAction'
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
Route::get('admin/version/create/{id}', [
		'as'   => 'version.create',
		'uses' => 'TestsController@versionAction'
	]
);
Route::post('admin/version', [
		'as'     => 'version.store',
		'before' => 'csrf',
		'uses'   => 'TestsController@storeVersionAction'
	]
);

/**
 * Question creation
 */
Route::get('admin/question/create/{id}', [
		'as'   => 'question.create',
		'uses' => 'QuestionController@createAction'
	]
);
Route::post('admin/question', [
		'as'     => 'question.store',
		'before' => 'csrf',
		'uses'   => 'QuestionController@storeAction'
	]
);
Route::get('admin/question/edit/{id}', [
		'as'   => 'question.edit',
		'uses' => 'QuestionController@editAction'
	]
);
Route::put('admin/question', [
		'as'     => 'question.update',
		'before' => 'csrf',
		'uses'   => 'QuestionController@updateAction'
	]
);
Route::delete('admin/question/{id}', [
		'as'   => 'question.destroy',
		'uses' => 'QuestionController@deleteAction'
	]
);

/**
 * Test results
 */
Route::get('admin/test/{id}/result', [
		'as'   => 'result.index',
		'uses' => 'ResultController@indexAction'
	]
);
Route::get('admin/test/{id}/result/{rid}', [
		'as'   => 'result.show',
		'uses' => 'ResultController@showAction'
	]
);

/**
 * Test results in CSV format
 */
Route::get('admin/test/{id}/csv', [
		'as'   => 'resultcsv.index',
		'uses' => 'ResultController@indexCsvAction'
	]
);

/**
 * Test results in XLS format
 */
Route::get('admin/test/{id}/xls', [
		'as'   => 'resultxls.index',
		'uses' => 'ResultController@indexXlsAction'
	]
);

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
 * Token creation
 */
Route::get('/token/{id}', [
		'as'   => 'token.create',
		'uses' => 'TokenController@createAction'
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

Route::get('/skip', [
		'as'   => 'skip.index',
		'uses' => 'TestController@skipAction'
	]
);

Route::post('/test', [
		'as'   => 'test.store',
		'uses' => 'TestController@storeAction'
	]
);

/**
 * Ajax - check test time
 */
Route::get('/test/check_status', [
		'as'   => 'check_status',
		'uses' => 'TestController@checkTime'
	]
);

/**
 * Ajax - mark result as correct
 */
Route::get('admin/test/result/correct/{id}', [
		'as'   => 'correct_result',
		'uses' => 'ResultController@resultCorrect'
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
