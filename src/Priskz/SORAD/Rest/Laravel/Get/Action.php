<?php

namespace Priskz\SORAD\Rest\Laravel\Get;

use Priskz\Payload\Payload;
use Priskz\SORAD\Action\LaravelAction;

class Action extends LaravelAction
{
	/**
	 *	Constructor
	 */
	public function __construct(Processor $processor)
	{
		parent::__construct($processor);
	}

	/**
	 *	Action Logic
	 */
	public function execute($data)
	{
		return $this->processor->process($data, $this->config);
	}
}