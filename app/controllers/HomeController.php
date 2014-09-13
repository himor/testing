<?php

/**
 * Class HomeController
 *
 * @author Mike Gordo <m.gordo@cityads.ru>
 */
class HomeController extends BaseController
{
	public function defaultAction()
	{
		/**
		 * По умолчанию мы редиректим на логин
		 */
		return Redirect::route('admin');
	}

}
