<?php

namespace Platron\Shtrihm\services;

use Platron\Shtrihm\data_objects\Customer;
use Platron\Shtrihm\data_objects\Payment;
use Platron\Shtrihm\data_objects\ReceiptPosition;
use Platron\Shtrihm\data_objects\Settlement;
use Platron\Shtrihm\handbooks\OperationType;
use Platron\Shtrihm\handbooks\TaxationSystem;

/**
 * Все парараметры обязательны для заполнения. Контактные данные требуются - либо email, либо телефон
 */
class CreateReceiptRequest extends BaseServiceRequest
{

	/** @var string идентификатор группы ККТ */
	protected $group;
	/** @var string тип операции */
	protected $operationType;
	/** @var string */
	protected $id;
	/** @var Customer */
	protected $customer;
	/** @var Settlement */
	protected $settlement;
	/** @var int */
	protected $inn;
	/** @var ReceiptPosition[] Позиции в чеке */
	protected $receiptPositions;
	/** @var Payment[] Оплаты */
	protected $payments;
	/** @var string */
	protected $taxationSystem;
	/** @var integer */
	protected $key;
	/** @var string */
	protected $additionalAttribute;

	/**
	 * @param int $id Идентификатор заказа
	 */
	public function __construct($id)
	{
		$this->id = $id;
	}

	/**
	 * @inheritdoc
	 */
	public function getRequestUrl()
	{
		return $this->getBaseUrl().'/documents/';
	}

	/**
	 * @param Customer $customer
	 */
	public function addCustomer(Customer $customer)
	{
		$this->customer = $customer;
	}

	/**
	 * @param Settlement $settlement
	 */
	public function addSettlement(Settlement $settlement)
	{
		$this->settlement = $settlement;
	}

	/**
	 * @param type $inn
	 */
	public function addInn($inn)
	{
		$this->inn = $inn;
	}

	/**
	 * @param ReceiptPosition $position
	 */
	public function addReceiptPosition(ReceiptPosition $position)
	{
		$this->receiptPositions[] = $position;
	}

	/**
	 * @param Payment $payment
	 */
	public function addPayment(Payment $payment)
	{
		$this->payments[] = $payment;
	}

	/**
	 * @param TaxationSystem $taxationSystem
	 */
	public function addTaxationSystem(TaxationSystem $taxationSystem)
	{
		$this->taxationSystem = $taxationSystem->getValue();
	}

	/**
	 * @param OperationType $operationType Тип операции. Из констант
	 */
	public function addOperationType(OperationType $operationType)
	{
		$this->operationType = $operationType;
	}

	/**
	 * @param $additionalAttribute
	 */
	public function addAdditionalAttribute($additionalAttribute)
	{
		$this->additionalAttribute = $additionalAttribute;
	}

	/**
	 * @param string $group Идентификатор группы ККТ
	 */
	public function addGroup($group)
	{
		$this->group = $group;
	}

	/**
	 * @param integer $key
	 */
	public function addKey($key)
	{
		$this->key = $key;
	}

	public function getParameters()
	{
		$items = [];
		foreach ($this->receiptPositions as $receiptPosition) {
			$items[] = $receiptPosition->getParameters();
		}
		$payments = [];
		foreach ($this->payments as $payment) {
			$payments[] = $payment->getParameters();
		}

		$params = [
			'Id' => $this->id,
			'INN' => $this->inn,
			'key' => $this->key,
			'Group' => $this->group,
			'additionalAttribute' => $this->additionalAttribute,
			'Content' => [
				'Type' => $this->operationType,
				'Positions' => $items,
				'CheckClose' => [
					'Payments' => $payments,
					'TaxationSystem' => $this->taxationSystem,
				],
			],
		];

		if ($this->customer) {
			$params['Content'] += $this->customer->getParameters();
		}

		if ($this->settlement) {
			$params['Content'] += $this->settlement->getParameters();
		}

		return $params;
	}
}
