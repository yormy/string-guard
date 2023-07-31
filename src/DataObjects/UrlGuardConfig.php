<?php

namespace Yormy\StringGuard\DataObjects;

class UrlGuardConfig extends StringGuardConfig
{
    public static function make(string $string, array $conditions = [], array $data = []): array
    {
        $urlConditions = ['methods' => $conditions];
        return parent::make($string, $urlConditions, $data);
    }
}
