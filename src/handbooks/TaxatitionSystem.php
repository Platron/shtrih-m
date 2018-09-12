<?php

namespace Platron\Shtrihm\handbooks;

use MyCLabs\Enum\Enum;

class TaxatitionSystem extends Enum
{
	const
		TAXATITION_SYSTEM_OSN = 0, // общая СН
		TAXATITION_SYSTEM_USN_INCOME = 1, // упрощенная СН (доходы)
		TAXATITION_SYSTEM_USN_INCOME_OUTCOME = 2, // упрощенная СН (доходы минус расходы)
		TAXATITION_SYSTEM_ENDV = 3, // единый налог на вмененный доход
		TAXATITION_SYSTEM_ESN = 4, // единый сельскохозяйственный налог
		TAXATITION_SYSTEM_PATENT = 5; // патентная СН
}