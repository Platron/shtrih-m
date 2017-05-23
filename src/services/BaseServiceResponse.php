<?php

namespace Platron\Shtrihm\services;

use Platron\Shtrihm\clients\iClient;
use stdClass;

abstract class BaseServiceResponse {
    
    /** @var int */
    protected $errorCode;
    /** @var int HTTP code */
    protected $httpCode;
    
    /**
     * @param iClient $client
     * @param stdClass $response
     */
    public function __construct(iClient $client, stdClass $response) {
        $this->client = $client->getLastHttpCode();
    }
    
    /**
     * Проверка на ошибки в ответе
     * @param array $response
     * @return boolean
     */
    public function isValid(){
        if(!empty($this->errorCode)){
            return false;
        }
        else {
            return true;
        }
    }
    
    /**
     * Получить код ошибки из ответа
     * @return int
     */
    public function getErrorCode(){
        return $this->errorCode;
    }
    
    /**
     * Получить описание ошибки
     * @return string
     */
    public function getErrorDescription(){
        return 'Failed with http code '.$this->errorCode;
    }
}
