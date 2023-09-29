<?php

namespace App\Traits\Enums;

use App\Enums\Models\Roles;
use ReflectionClass;

trait EnumToArrayConverterTrait
{
    /**
     * Returns an array of all enumeration values.
     *
     * @return array
     */
    public static function toArray(): array
    {
        $reflectionClass = new ReflectionClass(self::class);
        $constants = $reflectionClass->getConstants();

        return array_column($constants, 'value');
    }

    /**
     * Returns the enumeration element with the specified value.
     *
     * @param string|int $value
     * @return Roles|EnumToArrayConverterTrait|null
     */
    public static function fromValue(string|int $value): ?self
    {
        $reflectionClass = new ReflectionClass(self::class);
        $constants = $reflectionClass->getConstants();

        foreach ($constants as $enum) {
            if ($enum->value === $value) {
                return $enum;
            }
        }

        return null;
    }
}
