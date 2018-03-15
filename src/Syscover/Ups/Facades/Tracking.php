<?php namespace Syscover\Ups\Facades;

use Illuminate\Support\Facades\Facade;

class Tracking extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'ups.tracking'; }

}