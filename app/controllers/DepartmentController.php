<?php

/**
 * Class DepartmentController
 *
 * @author Mike Gordo <mgordo@live.com>
 */
class DepartmentController extends BaseController {

	protected $layout = 'layout.departments';

	/**
	 * Display all departments
	 */
	public function indexAction() {
		$departments = Department::all();

		return View::make('department.index', ['departments' => $departments]);
	}

	/**
	 * Display a page to create a new department
	 */
	public function createAction() {
		$department = new Department();

		return View::make('department.create', ['department' => $department]);
	}

	/**
	 * Create a new department
	 */
	public function storeAction() {
		$validation = Validator::make(Input::all(), Department::$rules);

		if (!$validation->passes()) {
			return Redirect::route('departments.create')
				->withInput()
				->withErrors($validation)
				->with('message', 'There were validation errors.');
		}

		/**
		 * Check name duplicates
		 */
		if (count(Department::where('name', Input::get('name'))->get())) {
			return Redirect::route('departments.create')
				->withInput()
				->with('message', 'This department already exists.');
		}

		$department = Department::create(Input::all());

		return Redirect::route('departments.show', $department->id);
	}

	/**
	 * Display one department
	 *
	 * @param $id
	 */
	public function showAction($id) {
		$department = Department::find($id);

		if (is_null($department))
			return Redirect::route('departments.index')
				->with('error', 'Incorrect department id');

		return View::make('department.show', ['department' => $department]);

	}

	/**
	 * Display a page where we can edit a department
	 *
	 * @param $id
	 */
	public function editAction($id) {
		$department = Department::find($id);

		if (is_null($department))
			return Redirect::route('departments.index')
				->with('error', 'Incorrect department id');

		return View::make('department.edit', ['department' => $department]);
	}

	/**
	 * Update the department
	 *
	 * @param $id
	 */
	public function updateAction($id) {
		$department = Department::find($id);
		$validation = Validator::make(Input::all(), Department::$rules);

		if (!$validation->passes()) {
			return Redirect::route('departments.edit', $id)
				->withInput()
				->withErrors($validation)
				->with('message', 'There were validation errors.');
		}

		/**
		 * Check name duplicates
		 */
		if (count(Department::where('name', Input::get('name'))->
			where('id', '!=', $id)->get())
		) {
			return Redirect::route('departments.edit', $id)
				->withInput()
				->with('message', 'This department already exists.');
		}

		$department->update(Input::all());
		$department->save();

		return Redirect::route('departments.show', $id);
	}

	/**
	 * Delete the department
	 *
	 * @param $id
	 */
	public function deleteAction($id) {
		$department = Department::find($id);

		if (is_null($department))
			return Redirect::route('departments.index')
				->with('error', 'Incorrect department id');

		DB::table('department')->where('id', $id)->delete();

		return Redirect::route('departments.index');
	}
}