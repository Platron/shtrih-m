<?php

namespace Platron\Shtrihm\tests\integration;

use PHPUnit\Framework\TestCase;

class IntegrationTestBase extends TestCase
{

	/** @var int */
	protected $inn;
	/** @var string */
	protected $groupCode;
	/** @var string Путь до приватного ключа */
	protected $secretKeyPath;
	/** @var string Путь до подписывающего содержание запроса ключа */
	protected $signedKeyPath;
	/** @var string Пароль приватного ключа */
	protected $keyPassword;
	/** @var string Путь до сертифката */
	protected $certPath;

	protected function setUp(): void
	{
		$this->inn = MerchantSettings::INN;
		$this->groupCode = MerchantSettings::GROUP_CODE;
		$this->secretKeyPath = 'tests/integration/merchant_data/' . MerchantSettings::SECRET_KEY_NAME;
		$this->keyPassword = MerchantSettings::KEY_PASSWORD;
		$this->signedKeyPath = 'tests/integration/merchant_data/' . MerchantSettings::SIGNED_KEY_PATH;
		$this->certPath = 'tests/integration/merchant_data/' . MerchantSettings::CERT_NAME;
	}
}
