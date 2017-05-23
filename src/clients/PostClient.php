<?php

namespace Platron\Shtrihm\clients;

use Platron\Shtrihm\SdkException;
use Platron\Shtrihm\services\BaseServiceRequest;

class PostClient implements iClient {
    
    /** @var string Строка приватного ключа */
    protected $secretKey;
    /** @var int Последний код http ответа */
    protected $lastHttpCode;
    
    /**
     * Секретный ключ для подписи запросов
     * @param string $secretKey
     */
    public function __construct($secretKey){
        $this->secretKey = $secretKey;
    }
    
    /**
     * @inheritdoc
     */
    public function sendRequest(BaseServiceRequest $service) {
        $requestParameters = $service->getParameters();
        
        $curl = curl_init($service->getRequestUrl());
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($requestParameters));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
        // Нужно сделать подпись документа перед отправкой
        
        $response = curl_exec($curl);
		
		if(curl_errno($curl)){
			throw new SdkException(curl_error($curl), curl_errno($curl));
		}
        
        $this->lastHttpCode = curl_getinfo($curl)['CURLINFO_HTTP_CODE'];
		
		return json_decode($response);
    }
    
    /**
     * @inretitdoc
     */
    public function getLastHttpCode(){
        return $this->lastHttpCode;
    }
}
