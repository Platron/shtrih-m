<?php

namespace Platron\Shtrihm\handbooks;

use MyCLabs\Enum\Enum;

class BarcodeTypes extends Enum
{
	const
		UNKNOW = "unknown",
		EAN8 = "ean8",
		EAN13 = "ean13",
		ITF14 = "itf14",
		GS1 = "gs1",
		SHORT = "short",
		FUR = "fur",
		EGAIS20 = "egais20",
		EGAIS30 = "egais30",
		F1 = "f1",
		F2 = "f2",
		F3 = "f3",
		F4 = "f4",
		F5 = "f5",
		F6 = "f6"
	;
}
