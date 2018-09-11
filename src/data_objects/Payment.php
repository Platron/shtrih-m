<?php

namespace Platron\Shtrihm\data_objects;

use Platron\Shtrihm\handbooks\PaymentType;

class Payment extends BaseDataObject
{
	/** @var int */
	protected $paymentType;
	/** @var float */
	protected $amount;

	/**
	 * Payment constructor.
	 * @param PaymentType $paymentType
	 * @param float $amount
	 */
	public function __construct(PaymentType $paymentType, $amount){
		$this->paymentType = $paymentType->getValue();
		$this->amount = $amount;
	}
}