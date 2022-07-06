<?php

namespace Platron\Shtrihm\data_objects;


use Platron\Shtrihm\handbooks\FFDVersion;

class Customer extends BaseDataObject
{
	/** @var int номер версии ФДД */
	private $ffdVersion;
	/** @var string */
	protected $inn;
	/** @var string */
	protected $name;
	/** @var string */
	protected $birthDate;
	/** @var string */
	protected $citizenship;
	/** @var string */
	protected $identityDocumentCode;
	/** @var string */
	protected $identityDocumentData;
	/** @var string */
	protected $address;

	/**
	 * @param int $ffdVersion
	 */
	public function __construct($ffdVersion = FFDVersion::V1_05)
	{
		$this->ffdVersion = $ffdVersion;
	}

	/**
	 * @param string $name
	 */
	public function addName($name)
	{
		$this->name = (string)$name;
	}

	/**
	 * @param string $inn
	 */
	public function addInn($inn)
	{
		$this->inn = (string)$inn;
	}

	/**
	 * @param string $birthDate
	 */
	public function addBirthDate($birthDate)
	{
		$this->birthDate = (string)$birthDate;
	}

	/**
	 * param string $citizenship
	 */
	public function addCitizenship($citizenship)
	{
		$this->citizenship = (string)$citizenship;
	}

	/**
	 * param string $identityDocumentCode
	 */
	public function addIdentityDocumentCode($identityDocumentCode)
	{
		$this->identityDocumentCode = (string)$identityDocumentCode;
	}

	/**
	 * param string $identityDocumentData
	 */
	public function addIdentityDocumentData($identityDocumentData)
	{
		$this->identityDocumentData = (string)$identityDocumentData;
	}

	/**
	 * param string $address
	 */
	public function addAddress($address)
	{
		$this->address = (string)$address;
	}

	public function getParameters()
	{
		if ($this->ffdVersion === FFDVersion::V1_05) {
			return [
				'customer' => $this->name,
				'customerINN' => $this->inn,
			];
		}

		return parent::getParameters();
	}
}