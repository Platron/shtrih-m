<?php

namespace Platron\Shtrihm\handbooks;

use MyCLabs\Enum\Enum;

class PaymentType extends Enum
{
	const
		CASH = 1,
		ELECTRON = 2,
		PRE_PAID = 14,
		CREDIT = 15,
		CONSIDERATION = 16;
}