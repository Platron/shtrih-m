<?php

namespace Platron\Shtrihm\services;

use stdClass;

abstract class BaseServiceResponse {
    
    /** @var int */
    protected $errorCode;
    
    /** @var stdClass */
    protected $response;
    
    /**
     * @param int $httpCode
     * @param stdClass $response
     */
    public function __construct($httpCode, stdClass $response) {
        $this->response = $response;
        foreach (get_object_vars($this) as $name => $value) {
			if (!empty($response->$name)) {
				$this->$name = $response->$name;
			}
		}
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
        return implode(', ', !empty($this->response) ? $this->response->errors : 'Error with code '.$this->errorCode);
    }
}
