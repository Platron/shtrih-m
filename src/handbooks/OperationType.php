<?php

namespace Platron\Shtrihm\handbooks;

use MyCLabs\Enum\Enum;

class OperationType extends Enum
{
	const
		OPERATION_TYPE_SELL = 1, // Приход
		OPERATION_TYPE_SELL_REFUND = 2, // Возврат прихода
		OPERATION_TYPE_BUY = 3, // Расход
		OPERATION_TYPE_BUY_REFUND = 4; // Возврат расхода
}