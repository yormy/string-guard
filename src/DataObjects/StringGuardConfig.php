<?php

namespace Yormy\StringGuard\DataObjects;

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

class StringGuardConfig
{
    public static function make(string $string, array $conditions = [], array $data = []): array
    {
        if (!$string) {
            throw new InvalidConfigException('Guarded String must be specified');
        }

        $structure = [];

        $structure[$string] = [
            'methods' => $conditions,
            'additionals' => $data,
        ];

        return $structure;
    }

}
