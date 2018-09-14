<?php

namespace Platron\Shtrihm\services;

class GetReceiptStatusRequest extends GetStatusRequest
{
	/**
	 * @inheritdoc
	 */
	public function getRequestUrl()
	{
		return $this->getBaseUrl() .'/documents/'. $this->inn . '/status/' . $this->id;
	}
}
