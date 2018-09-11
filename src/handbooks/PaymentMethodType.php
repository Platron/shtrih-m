<?php

namespace Platron\Shtrihm\handbooks;

use MyCLabs\Enum\Enum;

class PaymentMethodType extends Enum
{
	const
		FULL_PRE_PAYMENT = 1,
		PARTIALLY_PRE_PAID = 2,
		ADVANCE = 3,
		FULL_PAYMENT = 4,
		PARTIALLY_PAYMENT_AND_CREDIT = 5,
		TRANSFER_ON_CREDIT = 6,
		CREDIT_PAYMENT = 7;
}