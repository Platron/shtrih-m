<?php

namespace Platron\Shtrihm\data_objects;

use Platron\Shtrihm\handbooks\BarcodeTypes;

class Barcode extends BaseDataObject
{
	/** @var string */
	protected $type;
	/** @var string */
	protected $value;

	/**
	 * Barcode constructor
	 * @param BarcodeTypes $barcodeType
	 * @param string $value
	 */
	public function __construct(BarcodeTypes $barcodeType, $value)
	{
		$this->type = $barcodeType->getValue();
		$this->value = (string)$value;
	}

	public function getParameters()
	{
		$field = [];
		$field[$this->type] = $this->value;
		return $field;
	}

}
