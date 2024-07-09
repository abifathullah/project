<?php

namespace App\Utilities\Enums;

use ReflectionClass;

abstract class Enum
{
    /**
     * @return array<int, mixed>
     */
    public static function all(): array
    {
        $reflection = new ReflectionClass(static::class);

        return array_values($reflection->getConstants());
    }
}
