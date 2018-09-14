<?php

namespace Platron\Shtrihm\services;

class GetCorrectionStatusRequest extends GetStatusRequest
{
	/**
	 * @inheritdoc
	 */
	public function getRequestUrl()
	{
		return $this->getBaseUrl() .'/corrections/'. $this->inn . '/status/' . $this->id;
	}
}