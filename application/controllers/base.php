<?php

class Base_Controller extends Controller {

	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}

	/********************
	 * Facebook Auth
	 ********************/
	public static function getFB(){

		$config = array();
        $config['appId'] = '535852776460879';
        $config['secret'] = '2cd3cec829b086b917d886c771d86805';
        return new Facebook($config);
	}

}