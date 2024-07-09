<?php

namespace App\Utilities\Enums;

abstract class ProductType extends Enum
{
    /** @var string */
    public const TOOL = 'Tool';

    /** @var string */
    public const TRANSPORTATION = 'Transportation';

    /** @var string */
    public const WEAR = 'Wear';
}
