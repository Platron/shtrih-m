<?php

namespace Platron\Shtrihm\handbooks;

use MyCLabs\Enum\Enum;

class PaymentType extends Enum
{
	const
		CASH = 1,
		MIR = 2,
		VISA = 3,
		MASTERCARD = 4,
		ADDITIONAL_1 = 5,
		ADDITIONAL_2 = 6,
		ADDITIONAL_3 = 7,
		ADDITIONAL_4 = 8,
		ADDITIONAL_5 = 9,
		ADDITIONAL_6 = 10,
		ADDITIONAL_7 = 11,
		ADDITIONAL_8 = 12,
		ADDITIONAL_9 = 13,
		PRE_PAID = 14,
		CREDIT = 15,
		OTHER = 16;
}