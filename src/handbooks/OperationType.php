<?php

namespace Platron\Shtrihm\handbooks;

use MyCLabs\Enum\Enum;

class OperationType extends Enum
{
	const
		SELL = 1, // Приход
		SELL_REFUND = 2, // Возврат прихода
		BUY = 3, // Расход
		BUY_REFUND = 4; // Возврат расхода
}