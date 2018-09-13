<?php

namespace Platron\Shtrihm\handbooks;

use MyCLabs\Enum\Enum;

class TaxationSystem extends Enum
{
	const
		OSN = 0, // общая СН
		USN_INCOME = 1, // упрощенная СН (доходы)
		USN_INCOME_OUTCOME = 2, // упрощенная СН (доходы минус расходы)
		SYSTEM_ENDV = 3, // единый налог на вмененный доход
		ESN = 4, // единый сельскохозяйственный налог
		PATENT = 5; // патентная СН
}