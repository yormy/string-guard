<?php

namespace Yormy\StringGuard\Services;

use Yormy\StringGuard\DataObjects\StringGuardConfig;

class StringGuard
{
    public static function isIncluded(string $stringToCheck, array $conditionsTest, array $filterConfig): bool
    {
        return self::testInclude($stringToCheck, $conditionsTest, $filterConfig, false);
    }

    public static function isIncludedOrUnspecified(string $stringToCheck, array $conditionsTest, array $filterConfig): bool
    {
        return self::testInclude($stringToCheck, $conditionsTest, $filterConfig, true);
    }

    public static function getData(string $stringToCheck, array $conditionsTest, array $filterConfig): array
    {
        $configValue = [];
        // if not specified, then there is no data
        $found =  self::testInclude($stringToCheck, $conditionsTest, $filterConfig, false, $configValue);
        if ($found) {
            return $configValue['ADDITIONALS'];
        }
        return [];
    }

    private static function testInclude(string $stringToCheck, array $conditionsTest, array $filterConfig, bool $defaultIncluded = true, array &$configFound = []): bool
    {
        $stringToCheck = strtoupper($stringToCheck);
        $config = StringGuardConfig::fromArray($filterConfig);

        $asExcluded = self::specified($config->getExcludes(), $stringToCheck, $conditionsTest, $configFound);
        if ($asExcluded === true) {
            return false;
        }

        $asIncluded = self::specified($config->getIncludes(), $stringToCheck, $conditionsTest, $configFound);
        if ($asIncluded === true) {
            return true;
        }

        return $defaultIncluded;
    }

    private static function specified(array $includes, string $stringToCheck, array $conditionsTest, array &$configFound = []): bool
    {
        $conditionMatch = false;
        foreach ($includes as $urlConfig) {
            foreach ($urlConfig as $url => $data) {
                $urlFound = fnmatch($url, $stringToCheck);
                if ($urlFound) {

                    $conditionFound = self::conditionMatchFound($data['CONDITIONS'],$conditionsTest);
                    if ($conditionFound) {
                        $conditionMatch = true;
                        $configFound = $data;
                    }
                }
            }
        }

        return $conditionMatch;
    }

    private static function upperCase(array $values): array
    {
        $json = json_encode($values);
        $upper = strtoupper($json);

        return json_decode($upper, true);
    }

    private static function conditionMatchFound(array $config, array $toTest): bool
    {
        $config = self::upperCase($config);
        $toTest = self::upperCase($toTest);

        if (empty($toTest) || reset($toTest) === '*') {
            return true;
        }

        foreach ($config as $configName => $configValues)
        {
            if (isset($toTest[$configName])) {
                $valueToTest = $toTest[$configName];

                foreach ($configValues as $configValue) {
                    try {
                        $found = fnmatch($configValue, $valueToTest);
                    } catch (\Throwable $e) {
                        if (is_array($configValue)) {
                            $message = 'configValue cannot be an array: '. json_encode($configValue);
                            $message .= 'It might be that you passed additional data as second argument instead of third';
                            throw new \Exception($message);
                        }
                        throw $e;
                    }
                    if ($found) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}
