<?php

namespace Platron\Shtrihm\services;

class GetStatusRequest extends BaseServiceRequest{
    
    /** @var int */
    protected $id;
    /** @var int */
    protected $inn;
    
    /**
     * @inheritdoc
     */
    public function getRequestUrl() {
        return self::REQUEST_URL.$this->inn.'/status/'.$this->id;
    }
    
    /**
     * @param int $inn ИНН
     * @param int $id ID созданного документа
     */
    public function __construct($inn, $id) {
        $this->id = $id;
        $this->inn = $inn;
    }
    
    public function getParameters() {
        return [];
    }
}
