<?php

namespace Platron\Shtrihm\data_objects;


class Settlement extends BaseDataObject
{
	protected $address;
	protected $place;

	/**
	 * Settlement constructor.
	 * @param string $address
	 * @param string $place
	 */
	public function __construct($address, $place)
	{
		$this->address = $address;
		$this->place = $place;
	}

}