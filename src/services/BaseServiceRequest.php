<?php

namespace Platron\Shtrihm\services;

abstract class BaseServiceRequest {

	private $demoMode = false;

	const REQUEST_DEMO_URL = 'https://apip.orangedata.ru:2443/api/v2/documents/';
    const REQUEST_URL = 'https://api.orangedata.ru:12003/api/v2/documents/';

    public function setDemoMode()
	{
    	$this->demoMode = true;
	}

    /**
	 * Получить url ждя запроса
	 * @return string
	 */
	abstract public function getRequestUrl();

	public function getBaseUrl()
	{
		return $this->demoMode ? self::REQUEST_DEMO_URL : self::REQUEST_URL;
	}

    /**
	 * Получить параметры, сгенерированные командой
	 * @return array
	 */
	abstract function getParameters();
}
