<?php

namespace Platron\Shtrihm\data_objects;


class Customer extends BaseDataObject
{
	/** @var int */
	protected $phone;
	/** @var string */
	protected $email;
	/** @var int */
	protected $inn;
	/** @var string */
	protected $name;
	/** @var AdditionalAttribute */
	protected $additionalAttribute;

	/**
	 * @param $phone
	 */
	public function addPhone($phone)
	{
		$this->phone = $phone;
	}

	/**
	 * @param $email
	 */
	public function addEmail($email)
	{
		$this->email = $email;
	}

	/**
	 * @param $inn
	 */
	public function addInn($inn)
	{
		$this->inn = $inn;
	}

	/**
	 * @param $name
	 */
	public function addName($name)
	{
		$this->name = $name;
	}

	/**
	 * @param AdditionalAttribute $additionalAttribute
	 */
	public function addAdditionalAttribute(AdditionalAttribute $additionalAttribute)
	{
		$this->additionalAttribute = $additionalAttribute;
	}

	public function getParameters()
	{
		return [
			'CustomerContact' => $this->email ? $this->email : $this->phone,
			'customer' => $this->name,
			'customerINN' => $this->inn,
			'additionalUserAttribute' => $this->additionalAttribute ? $this->additionalAttribute->getParameters() : null,
		];
	}
}