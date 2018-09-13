<?php

namespace Platron\Shtrihm\services;

use Platron\Shtrihm\handbooks\CorrectionOperationTypes;
use Platron\Shtrihm\handbooks\CorrectionType;
use Platron\Shtrihm\handbooks\TaxationSystem;

class CreateCorrectionDocument extends BaseServiceRequest
{

	/** @var string */
	protected $id;
	/** @var int */
	protected $inn;
	/** @var integer */
	protected $key;
	/** @var string идентификатор группы ККТ */
	protected $group;
	/** @var string */
	protected $correctionType;
	/** @var string */
	protected $type;
	/** @var string */
	protected $description;
	/** @var string */
	protected $causeDocumentDate;
	/** @var float */
	protected $totalSum;
	/** @var float */
	protected $cashSum;
	/** @var float */
	protected $eCashSum;
	/** @var float */
	protected $prepaymentSum;
	/** @var float */
	protected $postpaymentSum;
	/** @var float */
	protected $otherPaymentTypeSum;
	/** @var float */
	protected $tax1Sum;
	/** @var float */
	protected $tax2Sum;
	/** @var float */
	protected $tax3Sum;
	/** @var float */
	protected $tax4Sum;
	/** @var float */
	protected $tax5Sum;
	/** @var float */
	protected $tax6Sum;
	/** @var string */
	protected $taxationSystem;
	/** @var string */
	protected $automatNumber;
	/** @var string */
	protected $settlementAddress;
	/** @var string */
	protected $settlementPlace;

	/**
	 * @param int $id Идентификатор заказа
	 */
	public function __construct($id)
	{
		$this->id = $id;
	}

	/**
	 * @return string|void
	 */
	public function getRequestUrl()
	{
		return $this->getBaseUrl().'/corrections/';
	}

	/**
	 * @param type $inn
	 */
	public function addInn($inn)
	{
		$this->inn = $inn;
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
	 * @param CorrectionType $correctionType
	 */
	public function addCorrectionType(CorrectionType $correctionType)
	{
		$this->correctionType = $correctionType->getValue();
	}

	public function addType(CorrectionOperationTypes $type)
	{
		$this->type = $type->getValue();
	}

	/**
	 * @param $description
	 */
	public function addDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * @param \DateTime $dateTime
	 */
	public function addCauseDocumentDate(\DateTime $dateTime)
	{
		$this->causeDocumentDate = $dateTime->format('Y-m-d H:i:s');
	}

	/**
	 * @param float $totalSum
	 */
	public function addTotalSum($totalSum)
	{
		$this->totalSum = $totalSum;
	}

	/**
	 * @param float $cashSum
	 */
	public function addCashSum($cashSum)
	{
		$this->cashSum = $cashSum;
	}

	/**
	 * @param float $eCashSum
	 */
	public function addECashSum($eCashSum)
	{
		$this->eCashSum = $eCashSum;
	}

	/**
	 * @param float $prepaymentSum
	 */
	public function addPrepaymentSum($prepaymentSum)
	{
		$this->prepaymentSum = $prepaymentSum;
	}

	/**
	 * @param float $postPaymentSum
	 */
	public function addPostPaymentSum($postPaymentSum)
	{
		$this->postpaymentSum = $postPaymentSum;
	}

	/**
	 * @param float $otherPaymentTypeSum
	 */
	public function addOtherPaymentTypeSum($otherPaymentTypeSum)
	{
		$this->otherPaymentTypeSum = $otherPaymentTypeSum;
	}

	/**
	 * @param float $tax1Sum
	 */
	public function addTax1Sum($tax1Sum)
	{
		$this->tax1Sum = $tax1Sum;
	}

	/**
	 * @param float $tax2Sum
	 */
	public function addTax2Sum($tax2Sum)
	{
		$this->tax2Sum = $tax2Sum;
	}

	/**
	 * @param float $tax3Sum
	 */
	public function addTax3Sum($tax3Sum)
	{
		$this->tax3Sum = $tax3Sum;
	}

	/**
	 * @param float $tax4Sum
	 */
	public function addTax4Sum($tax4Sum)
	{
		$this->tax4Sum = $tax4Sum;
	}

	/**
	 * @param float $tax5Sum
	 */
	public function addTax5Sum($tax5Sum)
	{
		$this->tax5Sum = $tax5Sum;
	}

	/**
	 * @param float $tax6Sum
	 */
	public function addTax6Sum($tax6Sum)
	{
		$this->tax6Sum = $tax6Sum;
	}

	/**
	 * @param TaxationSystem $taxationSystem
	 */
	public function addTaxationSystem(TaxationSystem $taxationSystem)
	{
		$this->taxationSystem = $taxationSystem->getValue();
	}

	/**
	 * @param string $automatNumber
	 */
	public function setAutomatNumber($automatNumber)
	{
		$this->automatNumber = $automatNumber;
	}

	/**
	 * @param string $settlementAddress
	 */
	public function setSettlementAddress($settlementAddress)
	{
		$this->settlementAddress = $settlementAddress;
	}

	/**
	 * @param string $settlementPlace
	 */
	public function setSettlementPlace($settlementPlace)
	{
		$this->settlementPlace = $settlementPlace;
	}

	function getParameters()
	{
		$fieldVars = array();
		foreach (get_object_vars($this) as $name => $value) {
			if ($value) {
				$fieldVars[$name] = $value;
			}
		}
		return $fieldVars;
	}
}