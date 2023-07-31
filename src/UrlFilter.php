<?php

namespace App\Console\Commands;

/*
specify without methods
 */
class UrlFilter
{
    const INCLUDED = 'INCLUDED';
    const EXCLUDED = 'EXCLUDED';
    const NOT_SPECIFIED = 'NOT_SPECIFIED';

    public static function config(string $url, array $methods =['*'], array $data = []): array
    {
        $structure = [];

        if (empty($data)) {
            $structure[$url] = $methods;
            return $structure;
        }

        $structure[$url] = [
            'methods' => $methods,
            'additionals' => $data,
        ];

        return $structure;
    }


    private static function getMethods(array $data): array
    {
        if (isset($data['methods'])) {
            return $data['methods'];
        }

        return $data;
    }

    private static function isIncludedMethod(string $method, array $specifiedMethods): bool
    {
        if (in_array('*', $specifiedMethods)) {
            return true;
        }

        if (in_array($method, $specifiedMethods)) {
            return true;
        }

        return false;

    }


}
