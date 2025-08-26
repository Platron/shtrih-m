<?php

namespace Platron\Shtrihm\data_objects;

class ElectronicPaymentsInfo extends BaseDataObject
{
	/** @var ElectronicPayment[] */
	protected $payments;

	/**
	 * @param ElectronicPayment[] $payments
	 */
	public function __construct(array $payments)
	{
		$this->payments = $payments;
	}

	public function getParameters()
	{
		if (empty($this->payments)) {
			return null;
		}
		$result = [];
		foreach ($this->payments as $payment) {
			$result[] = $payment->getParameters();
		}

		return ['payments' => $result];
	}

}