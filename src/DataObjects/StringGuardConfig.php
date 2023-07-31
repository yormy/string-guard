<?php

namespace Yormy\StringGuard\DataObjects;

use Yormy\StringGuard\Exceptions\InvalidConfigException;

class StringGuardConfig
{
    private $includes;
    private $excludes;

    public static function make(string $string, array $conditions = [], array $data = []): array
    {
        if (!$string) {
            throw new InvalidConfigException('Guarded String must be specified');
        }

        $structure = [];

        $structure[$string] = [
            'conditions' => $conditions,
            'additionals' => $data,
        ];

        return $structure;
    }

    public static function fromArray(array $config): StringGuardConfig
    {
        $object =  new StringGuardConfig();

        if (isset($config['include'])) {
            $object->includes = self::upperCase($config['include']);
        } else {
            throw new InvalidConfigException('Include must be specified, use ['*'] to include all');
        }

        if (isset($config['exclude'])) {
            $object->excludes = self::upperCase($config['exclude']);
        }

        return $object;
    }

    public function getIncludes()
    {
        return $this->includes;
    }

    public function getExcludes()
    {
        return $this->excludes;
    }

    private static function upperCase(array $values): array
    {
        $json = json_encode($values);
        $upper = strtoupper($json);

        return json_decode($upper, true);
    }
}
