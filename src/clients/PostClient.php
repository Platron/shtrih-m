<?php

namespace Platron\Shtrihm\clients;

use phpseclib\Crypt\RSA;
use Platron\Shtrihm\clients\iClient;
use Platron\Shtrihm\SdkException;
use Platron\Shtrihm\services\BaseServiceRequest;
use Psr\Log\LoggerInterface;
use stdClass;

class PostClient implements iClient {
    
    const LOG_LEVEL = 0;
    
    /** @var string путь до приватного ключа */
    protected $secretKeyPath;
    /** @var string пароль к ключу */
    protected $keyPassword;
    /** @var string путь до сертификата */
    protected $certPath;
    /** @var string путь до подписывающего ключа */
    protected $signKeyPath;
    
    /** @var int Последний код http ответа */
    protected $lastHttpCode;
    /** @var LoggerInterface */
    protected $logger;
    /** @var int */
    protected $connectionTimeout = 30;
    
    /**
     * Секретный ключ для подписи запросов
     * @param string $secretKeyPath
     */
    public function __construct($secretKeyPath, $keyPassword, $certPath, $signKeyPath){
        $this->secretKeyPath = $secretKeyPath;
        $this->certPath = $certPath;
        $this->keyPassword = $keyPassword;
        $this->signKeyPath = $signKeyPath;
    }
    
    /**
     * Установить логер
     * @param LoggerInterface $logger
     * @return self
     */
    public function setLogger(LoggerInterface $logger){
        $this->logger = $logger;
        return self;
    }
    
    /**
     * Установка максимального времени ожидания
     * @param int $connectionTimeout
     */
    public function setConnectionTimeout($connectionTimeout){
        $this->connectionTimeout = $connectionTimeout;
    }
    
    /**
     * @inheritdoc
     */
    public function sendRequest(BaseServiceRequest $service) {       
        $requestParameters = $service->getParameters();
        $requestUrl = $service->getRequestUrl();
        
        $curlHttpHeaders = array(
            'X-Signature: '.$this->getSignBase64(json_encode($requestParameters)),
            'Content-Type: application/json',
        );
        
        $curl = curl_init($requestUrl);
        if(!empty($requestParameters)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($requestParameters));
        }
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSLKEY, $this->secretKeyPath);
        curl_setopt($curl, CURLOPT_SSLKEYPASSWD, $this->keyPassword);
        curl_setopt($curl, CURLOPT_SSLCERT, $this->certPath);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $curlHttpHeaders);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->connectionTimeout);
        
        $response = curl_exec($curl);
        $this->lastHttpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        if($this->logger){
            $this->logger->log(self::LOG_LEVEL, 'Requested url '.$requestUrl.' params '. json_encode($requestParameters));
            $this->logger->log(self::LOG_LEVEL, 'Response '.$response);
            $this->logger->log(self::LOG_LEVEL, 'Response HTTP code '.$this->lastHttpCode);
        }
        	
		if(curl_errno($curl)){
			throw new SdkException(curl_error($curl), curl_errno($curl));
		}

		return $response ? json_decode($response) : new stdClass();
    }
    
    /**
     * @inretitdoc
     */
    public function getLastHttpCode(){
        return $this->lastHttpCode;
    }
    
    /**
     * Получить подпись
     * @param string $parameters
     * @return string
     */
    protected function getSignBase64($parameters){
        $rsa = new RSA();      
        $rsa->setPrivateKey(file_get_contents($this->signKeyPath));
        $rsa->setPrivateKeyFormat(RSA::PRIVATE_FORMAT_XML);
        $rsa->setHash('sha256');
        $rsa->setMGFHash('sha256');
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1);

        return base64_encode($rsa->sign($parameters));
    }
}
