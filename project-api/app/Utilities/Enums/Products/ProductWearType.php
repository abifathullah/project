<?php

namespace App\Utilities\Enums\Products;

use App\Utilities\Enums\Enum;

abstract class ProductWearType extends Enum
{
    /** @var string */
    public const SAFETY_GLASSES = 'Safety glasses';

    /** @var string */
    public const SAFETY_HELMET = 'Safety helmet';

    /** @var string */
    public const SAFETY_SHOES = 'Safety shoes';

    /** @var string */
    public const SAFETY_VEST = 'Safety vest';
}
