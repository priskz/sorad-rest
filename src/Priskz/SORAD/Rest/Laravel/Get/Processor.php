<?php

namespace Priskz\SORAD\Rest\Laravel\Get;

use Priskz\Payload\Payload;
use Priskz\Paylorm\Data\MySQL\Eloquent\CrudRepository;
use Priskz\SORAD\Action\Processor\Laravel\Processor as LaravelProcessor;

class Processor extends LaravelProcessor
{
	/**
	 * @var  array  Request data configuration.
	 */
	protected $config = [
		CrudRepository::PAGE_KEY   => '',
		CrudRepository::PER_KEY    => '',
		CrudRepository::FILTER_KEY => '',
		CrudRepository::ORDER_KEY  => '',
		CrudRepository::EMBED_KEY  => ''
	];

	/**
	 * Process the given data against the given rules and useable data keys.
	 *
	 * @param  array  $data
	 * @param  array  $config
	 * @return Payload
	 */
	public function process(array $data, array $config)
	{
		// Merge default or built-in configurations.
		$config = array_merge($this->config, $config);

		// Intersect the data given the with the data keys provided.
		$data = array_intersect_key($data, array_flip(array_keys($config)));

		// Validate and set our errors if they exist.
		$payload = $this->validator->validate($data, $config);

		// Return sanitized data if no validation errors exist.
		if( ! $payload->isStatus(Payload::STATUS_VALID))
		{
			return $payload;
		}

		// Grab payload data for more modification.
		$data = $payload->getData();

		if(array_key_exists(CrudRepository::PAGE_KEY, $data) && array_key_exists(CrudRepository::PER_KEY, $data))
		{
			$data[CrudRepository::PAGINATION_KEY] = [$data[CrudRepository::PAGE_KEY] => $data[CrudRepository::PER_KEY]];
		}

		if(array_key_exists(CrudRepository::FILTER_KEY, $data))
		{
			$data[CrudRepository::FILTER_KEY] = $data[CrudRepository::FILTER_KEY];
		}

		if(array_key_exists(CrudRepository::ORDER_KEY, $data))
		{
			$data[CrudRepository::ORDER_KEY] = $data[CrudRepository::ORDER_KEY];
		}

		if(array_key_exists(CrudRepository::EMBED_KEY, $data))
		{
			$data[CrudRepository::EMBED_KEY] = $data[CrudRepository::EMBED_KEY];
		}

		return new Payload($data, Payload::STATUS_VALID);
	}
}