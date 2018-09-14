<?php

namespace Platron\Shtrihm\services;

abstract class GetStatusRequest extends BaseServiceRequest
{

	/** @var int */
	protected $id;
	/** @var int */
	protected $inn;


	/**
	 * @param int $inn ИНН
	 * @param int $id ID созданного документа
	 */
	public function __construct($inn, $id)
	{
		$this->id = $id;
		$this->inn = $inn;
	}

	public function getParameters()
	{
		return [];
	}
}