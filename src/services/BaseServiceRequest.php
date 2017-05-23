<?php

namespace Platron\Shtrihm\services;

abstract class BaseServiceRequest {
    const REQUEST_URL = 'https://www.shtrih-m.ru/api/v1/documents/';
    
    /**
	 * Получить url ждя запроса
	 * @return string
	 */
	abstract public function getRequestUrl();
    
    /**
	 * Получить параметры, сгенерированные командой
	 * @return array
	 */
	public function getParameters() {
		$filledvars = array();
		foreach (get_object_vars($this) as $name => $value) {
			if ($value) {
				$filledvars[$name] = (string)$value;
			}
		}

		return $filledvars;
	}
}
