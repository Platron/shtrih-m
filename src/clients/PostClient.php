<?php

namespace Platron\Shtrihm\clients;

use Platron\Shtrihm\SdkException;
use Platron\Shtrihm\services\BaseServiceRequest;
use Psr\Log\LoggerInterface;

class PostClient implements iClient {
    
    const LOG_LEVEL = 0;
    
    /** @var string Строка приватного ключа */
    protected $secretKey;
    /** @var int Последний код http ответа */
    protected $lastHttpCode;
    /** @var LoggerInterface */
    protected $logger;
    
    /**
     * Секретный ключ для подписи запросов
     * @param string $secretKey
     * @param LoggerInterface $logger
     */
    public function __construct($secretKey, LoggerInterface $logger = null){
        $this->secretKey = $secretKey;
        $this->logger = $logger;
    }
    
    /**
     * @inheritdoc
     */
    public function sendRequest(BaseServiceRequest $service) {
        $requestParameters = $service->getParameters();
        $requestUrl = $service->getRequestUrl();
        
        $curl = curl_init($requestUrl);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($requestParameters));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		
        // Нужно сделать подпись документа перед отправкой
        
        $response = curl_exec($curl);
        
        if($this->logger){
            $this->logger->log(self::LOG_LEVEL, 'Requested url '.$requestUrl.' params '. print_r($requestParameters, true));
            $this->logger->log(self::LOG_LEVEL, 'Response '.$response);
        }
		
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
