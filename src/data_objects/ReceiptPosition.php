<?php

namespace Platron\Shtrihm\data_objects;

use Platron\Shtrihm\handbooks\PaymentMethodType;
use Platron\Shtrihm\handbooks\PaymentSubjectType;
use Platron\Shtrihm\handbooks\Vates;

class ReceiptPosition extends BaseDataObject
{

	/** @var string */
	protected $Tax;
	/** @var string */
	protected $Text;
	/** @var float */
	protected $Price;
	/** @var int */
	protected $Quantity;
	/** @var string */
	protected $paymentMethodType;
	/** @var string */
	protected $paymentSubjectType;
	/** @var string */
	protected $nomenclatureCode;
	/** @var string */
	protected $unitOfMeasurement;
	/** @var string */
	protected $additionalAttribute;
	/** @var string */
	protected $manufacturerCountryCode;
	/** @var string */
	protected $customsDeclarationNumber;
	/** @var string */
	protected $excise;
	/** @var Agent */
	protected $agent;
	/** @var Supplier */
	protected $supplier;

	/**
	 * @param string $name Описание товара
	 * @param float $price Цена товаров с учетом скидок
	 * @param float $quantity Количество товара
	 * @param Vates $vat Налоговая ставка из констант
	 */
	public function __construct($name, $price, $quantity, Vates $vat)
	{
		$this->Text = $name;
		$this->Price = $price;
		$this->Quantity = $quantity;
		$this->Tax = $vat->getValue();
	}

	/**
	 * @param PaymentMethodType $paymentMethodType
	 */
	public function addPaymentMethodType(PaymentMethodType $paymentMethodType)
	{
		$this->paymentMethodType = $paymentMethodType->getValue();
	}

	/**
	 * @param PaymentSubjectType $paymentSubjectType
	 */
	public function addPaymentSubjectType(PaymentSubjectType $paymentSubjectType)
	{
		$this->paymentSubjectType = $paymentSubjectType->getValue();
	}

	/**
	 * @param string $nomenclatureCode
	 */
	public function addNomenclatureCode($nomenclatureCode)
	{
		$this->nomenclatureCode = $nomenclatureCode;
	}

	/**
	 * @param string $unitOfMeasurement
	 */
	public function addUnitOfMeasurement($unitOfMeasurement)
	{
		$this->unitOfMeasurement = $unitOfMeasurement;
	}

	/**
	 * @param string $additionalAttribute
	 */
	public function addAdditionalAttribute($additionalAttribute)
	{
		$this->additionalAttribute = $additionalAttribute;
	}

	/**
	 * @param int $manufacturerCountryCode ISO 3 цифры
	 */
	public function addManufacturerCountryCode($manufacturerCountryCode)
	{
		$this->manufacturerCountryCode = $manufacturerCountryCode;
	}

	/**
	 * @param string $customsDeclarationNumber
	 */
	public function addCustomsDeclarationNumber($customsDeclarationNumber)
	{
		$this->customsDeclarationNumber = $customsDeclarationNumber;
	}

	/**
	 * @param float $excise
	 */
	public function addExcise($excise)
	{
		$this->excise = $excise;
	}

	/**
	 * @param Agent $agent
	 * @return $this
	 */
	public function addAgent(Agent $agent)
	{
		$this->agent = $agent;
	}

	/**
	 * @param Supplier $supplier
	 */
	public function addSupplier(Supplier $supplier)
	{
		$this->supplier = $supplier;
	}

	public function getParameters()
	{
		$parameters = parent::getParameters();

		unset($parameters['agent']);
		$parameters['agentType'] = $this->agent->getType();
		$parameters['agentInfo'] = $this->agent->getParameters();

		unset($parameters['supplier']);
		$parameters['supplierINN'] = $this->supplier->getInn();
		$parameters['supplierInfo'] = $this->supplier->getParameters();

		return $parameters;
	}
}
