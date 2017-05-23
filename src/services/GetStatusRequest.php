<?php

namespace Platron\Shtrihm\services;

class GetStatusRequest extends BaseServiceRequest{
    
    /** @var int */
    protected $id;
    
    /**
     * @inheritdoc
     */
    public function getRequestUrl() {
        return self::REQUEST_URL.'status/'.$this->id;
    }
    
    /**
     * Id документа, который создавался
     * @param int $id
     */
    public function __construct($id) {
        $this->id = $id;
    }
    
    public function getParameters() {
        return [];
    }
}
