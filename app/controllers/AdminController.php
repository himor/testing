<?php

/**
 * Class AdminController
 *
 * @author Mike Gordo <mgordo@live.com>
 */
class AdminController extends BaseController {

	public function defaultAction() {
		/**
		 * Which route should user be redirected after log in
		 */
		return Redirect::route('tests.index');
	}

}