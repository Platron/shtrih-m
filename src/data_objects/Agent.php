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
	 * @param string $paymentTransferOperatorPhoneNumber
	 * @return $this
	 */
	public function addPaymentTransferOperatorPhoneNumber($paymentTransferOperatorPhoneNumber)
	{
		$this->paymentTransferOperatorPhoneNumbers[] = $paymentTransferOperatorPhoneNumber;
		return $this;
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
	 * @param string $paymentAgentPhoneNumber
	 * @return $this
	 */
	public function addPaymentAgentPhoneNumber($paymentAgentPhoneNumber)
	{
		$this->paymentAgentPhoneNumbers[] = $paymentAgentPhoneNumber;
		return $this;
	}

	/**
	 * @param string $paymentOperatorName
	 * @return $this
	 */
	public function addPaymentOperatorName($paymentOperatorName)
	{
		$this->paymentOperatorName = $paymentOperatorName;
		return $this;
	}

	/**
	 * @param string $paymentOperatorAddress
	 * @return $this
	 */
	public function addPaymentOperatorAddress($paymentOperatorAddress)
	{
		$this->paymentOperatorAddress = $paymentOperatorAddress;
		return $this;
	}

	/**
	 * @param string $paymentOperatorINN
	 * @return $this
	 */
	public function addPaymentOperatorINN($paymentOperatorINN)
	{
		$this->paymentOperatorINN = $paymentOperatorINN;
		return $this;
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