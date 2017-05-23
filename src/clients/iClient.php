<?php

namespace Platron\Shtrihm\clients;

use Platron\Shtrihm\services\BaseServiceRequest;

interface iClient {
    
    /**
     * Послать запрос
     * @param \Platron\Shtrihm\BaseService $service
     */
    public function sendRequest(BaseServiceRequest $service);
}
