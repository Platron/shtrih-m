<?php

namespace Platron\Shtrihm\handbooks;

use MyCLabs\Enum\Enum;

class PaymentSubjectType extends Enum
{
	const
		PRODUCT = 1,
		TAX_PRODUCT = 2,
		WORK = 3,
		SERVICE = 4,
		GAMBLING_RATE = 5,
		GAMBLING_WINNING = 6,
		LOTTERY_TICKET = 7,
		LOTTERY_WINNING = 8,
		PROVIDING_RID = 9,
		PAYMENT = 10,
		AGENT_COMMISSION = 11,
		COMPOUND = 12,
		OTHER = 13;
}