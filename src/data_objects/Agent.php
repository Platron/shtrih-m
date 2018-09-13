<?php

namespace Platron\Shtrihm\data_objects;

use Platron\Shtrihm\handbooks\AgentTypes;

class Agent extends BaseDataObject
{
	/** @var int */
	protected $agentType;
	/** @var string */
	protected $paymentTransferOperatorPhoneNumbers;
	/** @var string */
	protected $paymentAgentOperation;
	/** @var string[] */
	protected $paymentAgentPhoneNumbers;
	/** @var string[] */
	protected $paymentOperatorPhoneNumbers;
	/** @var string */
	protected $paymentOperatorName;
	/** @var string */
	protected $paymentOperatorAddress;
	/** @var string */
	protected $paymentOperatorINN;

	/**
	 * Agent constructor.
	 * @param AgentTypes $agentType
	 */
	public function __construct(AgentTypes $agentType)
	{
		$this->agentType = $agentType->getValue();
	}

	/**
	 * @param int $paymentTransferOperatorPhoneNumber
	 */
	public function addPaymentTransferOperatorPhoneNumber($paymentTransferOperatorPhoneNumber)
	{
		$this->paymentTransferOperatorPhoneNumbers[] = '+' . $paymentTransferOperatorPhoneNumber;
	}

	/**
	 * @param string $paymentAgentOperation
	 * @return $this
	 */
	public function addPaymentAgentOperation($paymentAgentOperation)
	{
		$this->paymentAgentOperation = $paymentAgentOperation;
		return $this;
	}

	/**
	 * @param int $paymentAgentPhoneNumber
	 */
	public function addPaymentAgentPhoneNumber($paymentAgentPhoneNumber)
	{
		$this->paymentAgentPhoneNumbers[] = '+' . $paymentAgentPhoneNumber;
	}

	/**
	 * @param string $paymentOperatorName
	 */
	public function addPaymentOperatorName($paymentOperatorName)
	{
		$this->paymentOperatorName = $paymentOperatorName;
	}

	/**
	 * @param string $paymentOperatorAddress
	 */
	public function addPaymentOperatorAddress($paymentOperatorAddress)
	{
		$this->paymentOperatorAddress = $paymentOperatorAddress;
	}

	/**
	 * @param string $paymentOperatorINN
	 */
	public function addPaymentOperatorINN($paymentOperatorINN)
	{
		$this->paymentOperatorINN = $paymentOperatorINN;
	}

	/**
	 * @return int
	 */
	public function getType()
	{
		return $this->agentType;
	}

	/**
	 * @return array
	 */
	public function getParameters()
	{
		$parameters = parent::getParameters();
		unset($parameters['agentType']);
		return $parameters;
	}
}