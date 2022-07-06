<?php

namespace Platron\Shtrihm\data_objects;

class IndustryAttribute  extends BaseDataObject
{
	/** @var string */
	protected $foivId;
	/** @var string */
	protected $causeDocumentDate;
	/** @var string */
	protected $causeDocumentNumber;
	/** @var string */
	protected $value;

	/**
	 * @param string $foivId
	 */
	public function addFoivId($foivId)
	{
		$this->foivId = (string)$foivId;
	}

	/**
	 * @param string $causeDocumentDate
	 */
	public function addCauseDocumentDate($causeDocumentDate)
	{
		$this->causeDocumentDate = (string)$causeDocumentDate;
	}

	/**
	 * @param string $causeDocumentNumber
	 */
	public function addCauseDocumentNumber($causeDocumentNumber)
	{
		$this->causeDocumentNumber = (string)$causeDocumentNumber;
	}

	/**
	 * @param string $value
	*/
	public function addValue($value)
	{
		$this->value = (string)$value;
	}

}
