<?php

namespace Platron\Shtrihm\data_objects;

use Platron\Shtrihm\handbooks\PaymentType;

class Payment extends BaseDataObject
{
	/** @var int */
	protected $type;
	/** @var float */
	protected $amount;

	/**
	 * Payment constructor.
	 * @param PaymentType $type
	 * @param float $amount
	 */
	public function __construct(PaymentType $type, $amount){
		$this->type = $type->getValue();
		$this->amount = $amount;
	}
}