<?php

namespace Platron\Shtrihm\clients;

use Platron\Shtrihm\services\BaseServiceRequest;

interface iClient
{

	/**
	 * Послать запрос
	 * @param BaseServiceRequest $service
	 */
	public function sendRequest(BaseServiceRequest $service);

	/**
	 * Получить последний http ответ
	 * @return int
	 */
	public function getLastHttpCode();
}
