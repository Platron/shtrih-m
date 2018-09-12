<?php

namespace Platron\Shtrihm\data_objects;


class AdditionalAttribute extends BaseDataObject
{
	/** @var string */
	protected $name;
	/** @var string */
	protected $value;

	public function __construct($name, $value)
	{
		$this->name = $name;
		$this->value = $value;
	}
}