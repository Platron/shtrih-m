<?php

namespace Platron\Shtrihm\services;

use Platron\Shtrihm\clients\iClient;
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
    public $DeviceSN;
    /** @var string */
    public $DeviceRN;
    /** @var int */
    public $FSNumber;
    /** @var string */
    public $OFDName;
    /** @var string */
    public $OFDWebsite;
    /** @var int */
    public $OFDINN;
    /** @var string */
    public $FNSWebsite;
    /** @var int */
    public $DocumentNumber;
    /** @var int */
    public $ShiftNumber;
    /** @var int */
    public $DocumentIndex;
    /** @var int */
    public $ProcessedAt;
    /** @var int */
    public $FP;
    
    /**
     * @inheritdoc
     */
    public function __construct(iClient $client, stdClass $response) {
        
        if(!in_array($client->getLastHttpCode(), [self::HTTP_CODE_OK, self::HTTP_CODE_WAIT])){
            $this->errorCode = $client->getLastHttpCode();         
        }
        
        if($client->getLastHttpCode() == self::HTTP_CODE_OK ){
            $this->status = self::STATUS_DONE;
            parent::__construct($response);
            parent::__construct($response->Content);
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
