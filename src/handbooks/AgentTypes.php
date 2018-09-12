<?php

namespace Platron\Shtrihm\handbooks;

use MyCLabs\Enum\Enum;

class AgentTypes extends Enum
{
	const
		BANK_PAYMENT_AGENT = 1,
		BANK_PAYMENT_SUB_AGENT = 2,
		PAYMENT_AGENT = 4,
		PAYMENT_SUB_AGENT = 8,
		ATTORNEY_AGENT = 16, // поверенный
		COMMISSION = 32,
		OTHER_AGENT = 64;
}