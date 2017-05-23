<?php

namespace Platron\Shtrihm\tests\integration;

class MerchantSettings {
    const 
        INN = 123456789012,
        SECRET_KEY_NAME = 'merchant_private.key',
        GROUP_CODE = 'test';
    
    public static function getSecretKeyPath(){
        return 'merchant_data/'.self::SECRET_KEY_NAME;
    }
}
