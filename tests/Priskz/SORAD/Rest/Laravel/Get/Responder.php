<?php

namespace Priskz\SORAD\Rest\Laravel\Get;

use Priskz\SORAD\Responder\LaravelResponder;

class Responder extends LaravelResponder
{
	/**
	 *	Constructor
	 */
	public function __construct(Action $action)
	{
		$this->action = $action;
	}
}