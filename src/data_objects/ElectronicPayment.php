<?php

namespace Platron\Shtrihm\data_objects;

class ElectronicPayment extends BaseDataObject
{
	/** @var float */
	protected $amount;
	/** @var int */
	protected $type;
	/** @var string */
	protected $id;
	/** @var string */
	protected $additionalInfo;

	/**
	 * @param float $amount
	 * @param int $type
	 * @param string $id
	 */
	public function __construct(float $amount, int $type, string $id)
	{
		$this->amount = $amount;
		$this->type = $type;
		$this->id = $id;
	}

	public function setAdditionalInfo(string $additionalInfo): void
	{
		$this->additionalInfo = $additionalInfo;
	}

}