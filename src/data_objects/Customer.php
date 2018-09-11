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
	 * @return $this
	 */
	public function addPhone($phone)
	{
		$this->phone = $phone;
		return $this;
	}

	/**
	 * @param $email
	 * @return $this
	 */
	public function addEmail($email){
		$this->email = $email;
		return $this;
	}

	/**
	 * @param $inn
	 * @return $this
	 */
	public function addInn($inn){
		$this->inn = $inn;
		return $this;
	}

	/**
	 * @param $name
	 * @return $this
	 */
	public function addName($name){
		$this->name = $name;
		return $this;
	}

	/**
	 * @param AdditionalAttribute $additionalAttribute
	 * @return $this
	 */
	public function addAdditionalAttribute(AdditionalAttribute $additionalAttribute){
		$this->additionalAttribute = $additionalAttribute;
		return $this;
	}

	public function getParameters()
	{
		return [
			'CustomerContact' => $this->email ? $this->email : $this->phone,
			'customer' => $this->name,
			'customerINN' => $this->inn,
			'additionalUserAttribute' => $this->additionalAttribute->getParameters(),
		];
	}
}