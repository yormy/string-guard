<?php

namespace Yormy\StringGuard\Services;

/*
'example.co*' => [
    'conditions' => [
        'methods' => ['post', 'de*']
        'days' => ['sund', 'friday']
    ],
    'data' = [],
]
 */

use Yormy\StringGuard\Exceptions\InvalidConfigException;

class StringGuard
{
    public static function isIncluded(string $stringToCheck, string $method, array $filterConfig, bool $defaultIncluded = true): bool
    {
        $stringToCheck = strtoupper($stringToCheck);
        $method = strtoupper($method);

        // validate config
        $includes = null;
        if (isset($filterConfig['include'])) {
            $includes = self::upperCase($filterConfig['include']);
        }

        $excludes = null;
        if (isset($filterConfig['exclude'])) {
            $excludes = self::upperCase($filterConfig['exclude']);
        }

        $asExcluded = self::specifiedAsExclude($excludes, $stringToCheck, $method);
        if ($asExcluded === true) {
            return false;
        }

        $asIncluded = self::specifiedAsInclude($includes, $stringToCheck, $method);
        if ($asIncluded === true) {
            return true;
        }
//        dd('default');
        return $defaultIncluded;
//
//        return true; // how to deal with non specced urls
////        foreach ($includes as $urlConfig) {
////            foreach ($urlConfig as $url => $data) {
////                $urlFound = fnmatch($url, $urlToCheck);
////                if ($urlFound) {
////                    $specifiedMethods = self::getMethods($data);
////                    $methodFound = self::isIncludedMethod($method, $specifiedMethods);
////                    return $methodFound;
////                }
////            }
////        }
//        dd('not specced');
//        return false;
    }




    private static function specifiedAsExclude(array $excludes, string $urlToCheck, string $method)
    {
        foreach ($excludes as $urlConfig) {
            foreach ($urlConfig as $url => $data) {
                $urlFound = fnmatch($url, $urlToCheck);
                if ($urlFound) {
                    return $urlFound;
//                    $specifiedMethods = self::getMethods($data);
//                    $methodFound = self::isIncludedMethod($method, $specifiedMethods);
//                    if ($methodFound) {
//                        return false; // This url:method is specified as excluded, return immediately to override includes
//                    }
                }
            }
        }
    }


    private static function specifiedAsInclude(array $includes, string $stringToCheck, string $method)
    {
        foreach ($includes as $urlConfig) {
            foreach ($urlConfig as $url => $data) {
                $urlFound = fnmatch($url, $stringToCheck);
                return $urlFound;
//                if ($urlFound) {
//                    $specifiedMethods = self::getMethods($data);
//                    $methodFound = self::isIncludedMethod($method, $specifiedMethods);
//                    return $methodFound;
//                }
            }
        }
    }

    private static function upperCase(array $values): array
    {
        $json = json_encode($values);
        $upper = strtoupper($json);

        return json_decode($upper, true);
    }
}
