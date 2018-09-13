<?php

namespace Platron\Shtrihm\handbooks;

use MyCLabs\Enum\Enum;

class CorrectionType extends Enum
{
	const
		INDIVIDUALLY = 0, // самостоятельно
		BY_PRESCRIPTION = 1; // по предписанию
}