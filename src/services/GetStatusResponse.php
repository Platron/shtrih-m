<?php

namespace Platron\Shtrihm\services;

use stdClass;

class GetStatusResponse extends BaseServiceResponse {
    
    const 
        HTTP_CODE_OK = 200,
        HTTP_CODE_WAIT = 202;
    
    const 
        STATUS_DONE = 'ok',
        STATUS_WAIT = 'wait';
    
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
    public function __construct($httpCode, stdClass $response) {
        if(!in_array($httpCode, [self::HTTP_CODE_OK, self::HTTP_CODE_WAIT])){
            $this->errorCode = $httpCode;         
        }
        
        if($httpCode == self::HTTP_CODE_OK ){
            $this->status = self::STATUS_DONE;
            parent::__construct($httpCode, $response);
        }
        else {
            $this->status = $response->status;
        }
    }
    
    /**
     * Создан ли уже чек
     * @return boolean
     */
    public function isReceiptReady(){
        return $this->status == self::STATUS_DONE;
    }
}
