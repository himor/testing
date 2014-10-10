<?php

/**
 * Class AdminController
 *
 * @author Mike Gordo <mgordo@live.com>
 */
class AdminController extends BaseController
{
	public function defaultAction()
	{
		/**
		 * На какой роут мы редидектим при входе в админку
		 */
		return Redirect::route('tests.index');
	}

}