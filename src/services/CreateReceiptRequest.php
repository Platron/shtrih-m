<?php

namespace Platron\Shtrihm\services;

use Platron\Shtrihm\data_objects\AdditionalUserAttribute;
use Platron\Shtrihm\data_objects\Barcode;
use Platron\Shtrihm\data_objects\Customer;
use Platron\Shtrihm\data_objects\OperationalAttribute;
use Platron\Shtrihm\data_objects\Payment;
use Platron\Shtrihm\data_objects\IndustryAttribute;
use Platron\Shtrihm\data_objects\ReceiptPosition;
use Platron\Shtrihm\data_objects\Settlement;
use Platron\Shtrihm\handbooks\OperationType;
use Platron\Shtrihm\handbooks\TaxationSystem;
use Platron\Shtrihm\handbooks\FFDVersion;

/**
 * Все парараметры обязательны для заполнения. Контактные данные требуются - либо email, либо телефон
 */
class CreateReceiptRequest extends BaseServiceRequest
{
	/** @var int номер версии ФДД */
	protected $ffdVersion;
	/** @var string идентификатор группы ККТ */
	protected $group;
	/** @var string */
	protected $meta;
	/** @var string тип операции */
	protected $operationType;
	/** @var string */
	protected $id;
	/** @var string */
	protected $customerContact;
	/** @var Customer */
	protected $customer;
	/** @var OperationalAttribute */
	protected $operationalAttribute;
	/** @var  IndustryAttribute */
	protected $industryAttribute;
	/** @var Barcode */
	protected $barcodes;
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
	/** @var AdditionalUserAttribute */
	protected $additionalUserAttribute;

	/**
	 * @param int $id Идентификатор заказа
	 * @param int $ffdVersion
	 */
	public function __construct($id, $ffdVersion = FFDVersion::V1_05)
	{
		$this->id = $id;
		$this->ffdVersion = $ffdVersion;
	}

	/**
	 * @inheritdoc
	 */
	public function getRequestUrl()
	{
		return $this->getBaseUrl() . '/documents/';
	}

	/**
	 * @param string $customerContact
	 */
	public function addCustomerContact($customerContact)
	{
		$this->customerContact = $customerContact;
	}

	/**
	 * @param Customer $customer
	 */
	public function addCustomer(Customer $customer)
	{
		$this->customer = $customer;
	}

	/**
	 * @param OperationalAttribute $operationalAttribute
	 */
	public function addOperationalAttribute($operationalAttribute)
	{
		$this->operationalAttribute = $operationalAttribute;
	}

	/**
	 * @param IndustryAttribute $industryAttribute
	 */
	public function addIndustryAttribute($industryAttribute)
	{
		$this->industryAttribute = $industryAttribute;
	}

	/**
	 * @param Barcode
	 */
	public function addBarcodes($barcodes)
	{
		$this->barcodes = $barcodes;
	}

	/**
	 * @param Settlement $settlement
	 */
	public function addSettlement(Settlement $settlement)
	{
		$this->settlement = $settlement;
	}

	/**
	 * @param int $inn
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
	 * @param AdditionalUserAttribute $additionalUserAttribute
	 */
	public function addAdditionalUserAttribute(AdditionalUserAttribute $additionalUserAttribute)
	{
		$this->additionalUserAttribute = $additionalUserAttribute;
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

	/**
	 * @param string $meta
	 */
	public function addMeta($meta)
	{
		$this->meta = $meta;
	}

	/**
	 * @param bool $ignoreItemCodeCheck
	 */
	public function addIgnoreItemCodeCheck($ignoreItemCodeCheck)
	{
		$this->ignoreItemCodeCheck = $ignoreItemCodeCheck;
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
			'id' => $this->id,
			'inn' => $this->inn,
			'key' => $this->key,
			'group' => $this->group,
			'meta' => $this->meta,
			'content' => [
				'ffdVersion' => $this->ffdVersion,
				'type' => $this->operationType,
				'positions' => $items,
				'checkClose' => [
					'payments' => $payments,
					'taxationSystem' => $this->taxationSystem,
				],
				'customerContact' => $this->customerContact,
				'additionalAttribute' => $this->additionalAttribute,
			],
		];


		if ($this->additionalUserAttribute) {
			$params['content']['additionalUserAttribute'] = $this->additionalUserAttribute->getParameters();
		}

		if ($this->ffdVersion === FFDVersion::V1_2) {

			if ($this->customer) {
				$params['content']['customerInfo'] = $this->customer->getParameters();
			}

			if ($this->operationalAttribute) {
				$params['content']['operationalAttribute'] = $this->operationalAttribute->getParameters();
			}

			if ($this->industryAttribute) {
				$params['content']['industryAttribute'] = $this->industryAttribute->getParameters();
			}

		} else {

			if ($this->customer) {
				$params['content'] += $this->customer->getParameters();
			}
		}

		if ($this->settlement) {
			$params['content'] += $this->settlement->getParameters();
		}

		return $params;
	}
}
