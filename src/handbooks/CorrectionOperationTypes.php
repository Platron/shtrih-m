<?php

namespace Platron\Shtrihm\handbooks;

use MyCLabs\Enum\Enum;

class CorrectionOperationTypes extends Enum
{
	const
		SELL = OperationType::SELL,
		BUY = OperationType::BUY;
}