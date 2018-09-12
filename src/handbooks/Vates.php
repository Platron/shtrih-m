<?php

namespace Platron\Shtrihm\handbooks;

use MyCLabs\Enum\Enum;

class Vates extends Enum
{
	const
		TAX_NONE = 6,
		TAX_VAT0 = 5,
		TAX_VAT10 = 2,
		TAX_VAT18 = 1,
		TAX_VAT110 = 4,
		TAX_VAT118 = 3;
}