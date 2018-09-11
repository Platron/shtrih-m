<?php

namespace Platron\Shtrihm\handbooks;

use MyCLabs\Enum\Enum;

class AgentTypes extends Enum
{
	const
		BANK_PAYMENT_AGENT = 0,
		BANK_PAYMENT_SUB_AGENT = 1,
		PAYMENT_AGENT = 2,
		PAYMENT_SUB_AGENT = 3,
		ATTORNEY_AGENT = 4, // поверенный
		COMMISSION = 5,
		OTHER_AGENT = 6;
}