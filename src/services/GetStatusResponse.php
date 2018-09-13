<?php

namespace Platron\Shtrihm\services;

use stdClass;

class GetStatusResponse extends BaseServiceResponse
{

	const
		HTTP_CODE_OK = 200,
		HTTP_CODE_WAIT = 202;

	const
		STATUS_DONE = 'ok',
		STATUS_WAIT = 'wait',
		STATUS_ERROR = 'error';

	/** @var string */
	public $status;
	/** @var string */
	public $deviceSN;
	/** @var string */
	public $deviceRN;
	/** @var int */
	public $fsNumber;
	/** @var string */
	public $ofdName;
	/** @var string */
	public $ofdWebsite;
	/** @var int */
	public $ofdinn;
	/** @var string */
	public $fnsWebsite;
	/** @var int */
	public $documentNumber;
	/** @var int */
	public $shiftNumber;
	/** @var int */
	public $documentIndex;
	/** @var int */
	public $processedAt;
	/** @var int */
	public $fp;

	/**
	 * @inheritdoc
	 */
	public function __construct($httpCode, stdClass $response)
	{
		if ($httpCode == self::HTTP_CODE_OK) {
			$this->status = self::STATUS_DONE;
			parent::__construct($httpCode, $response);
		} elseif ($httpCode == self::HTTP_CODE_WAIT) {
			$this->status = self::STATUS_WAIT;
		} else {
			$this->errorCode = $httpCode;
			$this->status = self::STATUS_ERROR;
		}
	}

	/**
	 * Создан ли уже чек
	 * @return boolean
	 */
	public function isReceiptReady()
	{
		return $this->status == self::STATUS_DONE;
	}
}
