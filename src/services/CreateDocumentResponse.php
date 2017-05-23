<?php

namespace Platron\Shtrihm\services;

use Platron\Shtrihm\clients\iClient;
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
    public function __construct(iClient $client, stdClass $response) {
        if($client->getLastHttpCode() != self::HTTP_CODE_OK){
            $this->errorCode = $client->getLastHttpCode();
        }
    }
}
