<?php

namespace Platron\Shtrihm\data_objects;

use Platron\Shtrihm\handbooks\PaymentMethodType;
use Platron\Shtrihm\handbooks\PaymentSubjectType;
use Platron\Shtrihm\handbooks\Vates;

class ReceiptPosition extends BaseDataObject
{

	/** @var string */
	protected $tax;
	/** @var string */
	protected $text;
	/** @var float */
	protected $price;
	/** @var int */
	protected $quantity;
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
	/** @var FractionalQuantity */
	protected $fractionalQuantity;
	/** @var IndustryAttribute */
	protected $industryAttribute;
	/** @var Barcode */
	protected $barcodes;
	/** @var float */
	protected $unitTaxSum;
	/** @var int */
	protected $quantityMeasurementUnit;
	/** @var string */
	protected $itemCode;
	/** @var int */
	protected $plannedStatus;

	/**
	 * @param string $name Описание товара
	 * @param float $price Цена товаров с учетом скидок
	 * @param float $quantity Количество товара
	 * @param Vates $vat Налоговая ставка из констант
	 */
	public function __construct($name, $price, $quantity, Vates $vat)
	{
		$this->text = $name;
		$this->price = $price;
		$this->quantity = $quantity;
		$this->tax = $vat->getValue();
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

	/**
	 * @param FractionalQuantity $fractionalQuantity
	 */
	public function addFractionalQuantity(FractionalQuantity $fractionalQuantity)
	{
		$this->fractionalQuantity = $fractionalQuantity;
	}

	/**
	 * @param IndustryAttribute $industryAttribute
	 */
	public function addIndustryAttribute(IndustryAttribute $industryAttribute)
	{
		$this->industryAttribute = $industryAttribute;
	}

	/**
	 * @param Barcode $barcodes
	 */
	public function addBarcodes($barcodes)
	{
		$this->barcodes = $barcodes;
	}

	/**
	 * @param float $unitTaxSum
	 */
	public function addUnitTaxSum($unitTaxSum)
	{
		$this->unitTaxSum = (float)$unitTaxSum;
	}

	/**
	 * @param int $quantityMeasurementUnit
	 */
	public function addQuantityMeasurementUnit($quantityMeasurementUnit)
	{
		$this->quantityMeasurementUnit = (int)$quantityMeasurementUnit;
	}

	/**
	 * @param string $itemCode
	 */
	public function addItemCode($itemCode)
	{
		$this->itemCode = (string)$itemCode;
	}

	/**
	 * @return int $plannedStatus
	 */
	public function addPlannedStatus($plannedStatus)
	{
		$this->plannedStatus = (int)$plannedStatus;
	}

	public function getParameters()
	{
		$parameters = parent::getParameters();

		if(!empty($parameters['agent'])) {
			unset($parameters['agent']);
			$parameters['agentType'] = $this->agent->getType();
			$parameters['agentInfo'] = $this->agent->getParameters();
		}

		if(!empty($parameters['supplier'])) {
			unset($parameters['supplier']);
			$parameters['supplierINN'] = $this->supplier->getInn();
			$parameters['supplierInfo'] = $this->supplier->getParameters();
		}
		return $parameters;
	}
}
