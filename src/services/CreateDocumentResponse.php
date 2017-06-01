<?php

namespace Platron\Shtrihm\services;

use Platron\Shtrihm\services\BaseServiceResponse;
use stdClass;

class CreateDocumentResponse extends BaseServiceResponse {
    
    const HTTP_CODE_OK = 201;
    
    /** @var string Уникальный идентификатор */
    public $uuid;
    
    /** @var string */
    public $status;
    
    /**
     * @inheritdoc
     */    
    public function __construct($httpCode, stdClass $response) {
        if($httpCode != self::HTTP_CODE_OK){
            $this->errorCode = $httpCode;
        }
        parent::__construct($httpCode, $response);
    }
}
