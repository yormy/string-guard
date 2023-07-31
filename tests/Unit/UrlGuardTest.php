<?php

namespace Yormy\StringGuard\Tests\Unit;

use Yormy\StringGuard\DataObjects\StringGuardConfig;
use Yormy\StringGuard\DataObjects\UrlGuardConfig;
use Yormy\StringGuard\Services\StringGuard;
use Yormy\StringGuard\Services\UrlGuard;
use Yormy\StringGuard\Tests\TestCase;

class UrlGuardTest extends TestCase
{
    private array $config;

    public function setUp(): void
    {
        $this->config = $this->makeConfig();
    }

    /**
     * @test
     * @group xxx
     */
    public function UrlIncludeSpecified_Match_Included(): void
    {
        $included = UrlGuard::isIncluded('include_x', 'post', $this->config);
        $this->assertTrue($included);

        $included = UrlGuard::isIncluded('include_', 'post', $this->config);
        $this->assertTrue($included);
    }

    /**
     * @test
     * @group StringGuard
     */
    public function UrlIncludeSpecified_GetData_Success(): void
    {
        $conditionsTest = ['methods' => 'post'];

        $includedData = UrlGuard::getData('include_x', 'post', $this->config);
        $this->assertEquals($includedData['TEST'], 'TEST');
    }

    //---------- HELPERS ----------
    private function makeConfig(): array
    {
        $data = ['test' => 'test'];

        return [
            'include' => [
                UrlGuardConfig::make('include_*', ['post', 'delete'], $data),
            ],
            'exclude' => [
                UrlGuardConfig::make('exclude_*', ['post', 'delete'], $data),
            ]
        ];

    }
}
