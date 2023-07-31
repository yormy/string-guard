<?php

namespace Yormy\StringGuard\Tests\Unit;

use Yormy\StringGuard\DataObjects\StringGuardConfig;
use Yormy\StringGuard\Services\StringGuard;
use Yormy\StringGuard\Tests\TestCase;

class IncludeTest extends TestCase
{
    private array $config;

    public function setUp(): void
    {
        $this->config = $this->makeConfig();
    }

    /**
     * @test
     * @group StringGuard
     */
    public function IncludeSpecified_Match_Included(): void
    {
        $included = StringGuard::isIncluded('include_x', [], $this->config);
        $this->assertTrue($included);

        $included = StringGuard::isIncluded('include_', [], $this->config);
        $this->assertTrue($included);
    }

    /**
     * @test
     */
    public function IncludeSpecified_UnMatchExclude_Excluded(): void
    {
        $included = StringGuard::isIncluded('inclu', [], $this->config, false);
        $this->assertFalse($included);
    }

    /**
     * @test
     */
    public function IncludeSpecified_UnMatchInclude_Included(): void
    {
        $included = StringGuard::isIncludedOrUnspecified('inclu', [], $this->config);
        $this->assertTrue($included);
    }

    /**
     * @test
     */
    public function ExcludeSpecified_Match_Excluded(): void
    {
        $included = StringGuard::isIncluded('exclude_s', [], $this->config);

        $this->assertFalse($included);
    }

    /**
     * @test
     */
    public function ExcludeSpecified_UnMatchExclude_Excluded(): void
    {
        $included = StringGuard::isIncluded('excie', [], $this->config);

        $this->assertFalse($included);
    }

    /**
     * @test
     */
    public function ExcludeSpecified_UnMatchInclude_Included(): void
    {
        $included = StringGuard::isIncludedOrUnspecified('excie', [], $this->config);

        $this->assertTrue($included);
    }

    //---------- HELPERS ----------
    private function makeConfig(): array
    {
        return [
            'include' => [
                StringGuardConfig::make('include_*', [[], 'delete']),
            ],
            'exclude' => [
                StringGuardConfig::make('exclude_*', [[], 'delete']),
            ]
        ];

    }
}
