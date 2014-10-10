<?php

/**
 * Class CategoriesController
 *
 * @author Mike Gordo <mgordo@live.com>
 */
class CategoriesController extends BaseController {

	protected $layout = 'layout.categories';

	/**
	 * Display all categories
	 */
	public function indexAction() {
		$categories = Category::all();

		return View::make('category.index', ['categories' => $categories]);
	}

	/**
	 * Display a page to create a new category
	 */
	public function createAction() {
		$category = new Category();

		return View::make('category.create', ['category' => $category]);
	}

	/**
	 * Create a new category
	 */
	public function storeAction() {
		$validation = Validator::make(Input::all(), Category::$rules);

		if (!$validation->passes()) {
			return Redirect::route('categories.create')
				->withInput()
				->withErrors($validation)
				->with('message', 'There were validation errors.');
		}

		/**
		 * Check name duplicates
		 */
		if (count(Category::where('name', Input::get('name'))->get())) {
			return Redirect::route('categories.create')
				->withInput()
				->with('message', 'This category already exists.');
		}

		$category = Category::create(Input::all());

		return Redirect::route('categories.show', $category->id);
	}

	/**
	 * Display one category
	 *
	 * @param $id
	 */
	public function showAction($id) {
		$category = Category::find($id);

		if (is_null($category))
			return Redirect::route('categories.index')
				->with('error', 'Incorrect category id');

		return View::make('category.show', ['category' => $category]);
	}

	/**
	 * Display a page where we can edit the category
	 *
	 * @param $id
	 */
	public function editAction($id) {
		$category = Category::find($id);

		if (is_null($category))
			return Redirect::route('categories.index')
				->with('error', 'Incorrect category id');

		return View::make('category.edit', ['category' => $category]);
	}

	/**
	 * Update the category
	 *
	 * @param $id
	 */
	public function updateAction($id) {
		$category   = Category::find($id);
		$validation = Validator::make(Input::all(), Category::$rules);

		if (!$validation->passes()) {
			return Redirect::route('categories.edit', $id)
				->withInput()
				->withErrors($validation)
				->with('message', 'There were validation errors.');
		}

		/**
		 * Check name duplicates
		 */
		if (count(Category::where('name', Input::get('name'))->
			where('id', '!=', $id)->get())
		) {
			return Redirect::route('categories.edit', $id)
				->withInput()
				->with('message', 'This category already exists.');
		}

		$category->update(Input::all());
		$category->save();

		return Redirect::route('categories.show', $id);
	}

	/**
	 * Delete the category
	 *
	 * @param $id
	 */
	public function deleteAction($id) {
		$category = Category::find($id);

		if (is_null($category))
			return Redirect::route('categories.index')
				->with('error', 'Incorrect category id');

		/**
		 * Check if in use
		 */
		if (count(Test::where('category_id', $id)->get())
		) {
			return Redirect::route('categories.edit', $id)
				->withInput()
				->with('message', 'This category is in use and cannot be deleted.');
		}

		DB::table('category')->where('id', $id)->delete();

		return Redirect::route('categories.index');
	}
}