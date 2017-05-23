<?php

namespace Platron\Shtrihm\tests\integration;

use Platron\Shtrihm\tests\integration\MerchantSettings;

class IntegrationTestBase extends \PHPUnit_Framework_TestCase {

    /** @var int */
    protected $inn;
    /** @var string */
    protected $groupCode;
    /** @var string Содержание приватного ключа */
    protected $secretKey;
    
    public function __construct() {
        $this->inn = MerchantSettings::INN;
        $this->groupCode = MerchantSettings::GROUP_CODE;
        $this->secretKey = file_get_contents(MerchantSettings::getSecretKeyPath());
    }
}
