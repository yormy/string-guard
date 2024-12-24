<?php

namespace Yormy\StringGuard\Tests\Unit;

use Yormy\StringGuard\DataObjects\StringGuardConfig;
use Yormy\StringGuard\Exceptions\InvalidConfigException;
use Yormy\StringGuard\Tests\TestCase;

class ConfigTest extends TestCase
{
    /**
     * @test
     */
    public function CreateEmptyConfig_Failed(): void
    {
        $this->expectException(InvalidConfigException::class);
        StringGuardConfig::make('');
    }
}
