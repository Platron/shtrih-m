<?php

namespace Platron\Shtrihm\data_objects;


class Supplier extends BaseDataObject
{
	/** @var int */
	protected $inn;
	/** @var string */
	protected $name;
	/** @var int[] */
	protected $phoneNumbers;

	/**
	 * Supplier constructor.
	 * @param $inn
	 * @param $name
	 */
	public function __construct($inn, $name)
	{
		$this->inn = $inn;
		$this->name = $name;
	}

	/**
	 * @param int $phone
	 * @return $this
	 */
	public function addPhone($phone){
		$this->phoneNumbers[] = '+'.$phone;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getInn()
	{
		return $this->inn;
	}

	/**
	 * @return array
	 */
	public function getParameters()
	{
		$parameters = parent::getParameters();
		unset($parameters['inn']);
		return $parameters;
	}
}