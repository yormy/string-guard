<?php

namespace Yormy\StringGuard\Services;

class UrlGuard extends StringGuard
{
    public static function isIncluded(string $stringToCheck, array|string $conditionsTest, array $filterConfig): bool
    {
        $urlConditionsTest = self::convertConditionTest($conditionsTest);
        return parent::isIncluded($stringToCheck, $urlConditionsTest, $filterConfig);
    }

    public static function isIncludedOrUnspecified(string $stringToCheck, array|string $conditionsTest, array $filterConfig): bool
    {
        $urlConditionsTest = self::convertConditionTest($conditionsTest);
        return parent::isIncludedOrUnspecified($stringToCheck, $urlConditionsTest, $filterConfig);
    }

    public static function getData(string $stringToCheck, array|string $conditionsTest, array $filterConfig): array
    {
        $urlConditionsTest = self::convertConditionTest($conditionsTest);
        return parent::getData($stringToCheck, $urlConditionsTest, $filterConfig);
    }

    private static function convertConditionTest($specific): array
    {
        return ['methods' => $specific];
    }
}
