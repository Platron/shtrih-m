<?php


namespace Platron\Shtrihm\data_objects;

class OperationalAttribute extends BaseDataObject{

	/** @var string */
	protected $date;
	/** @var int */
	protected $id;
	/** @var string */
	protected $value;

	/**
	 * OperationalAttribute constructor
	 * @param int $id
	 */
	public function __construct($id = 0)
	{
		$this->id = (int)$id;
	}

	/**
	 * @param string $date
	 */
	public function addDate($date)
	{
		$this->date = (string)$date;
	}


	/**
	 * @param string $value
	 */
	public function addValue($value)
	{
		$this->value = (string)$value;
	}

}
