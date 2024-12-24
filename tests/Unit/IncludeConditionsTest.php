<?php

namespace Yormy\StringGuard\Tests\Unit;

use Yormy\StringGuard\DataObjects\StringGuardConfig;
use Yormy\StringGuard\Services\StringGuard;
use Yormy\StringGuard\Tests\TestCase;

class IncludeConditionsTest extends TestCase
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
    public function IncludeSpecifiedWithConditions_ConditionsMatchInclude_Included(): void
    {
        $conditionsTest = ['methods' => 'post'];

        $included = StringGuard::isIncluded('include_x', $conditionsTest, $this->config);
        $this->assertTrue($included);
    }

    /**
     * @test
     * @group StringGuard
     */
    public function IncludeSpecifiedWithConditions_ConditionsUnMatchInclude_Excluded(): void
    {
        $conditionsTest = ['methods' => 'getty'];

        $included = StringGuard::isIncluded('include_x', $conditionsTest, $this->config, false);
        $this->assertFalse($included);
    }

    /**
     * @test
     * @group StringGuard
     */
    public function ExcludeSpecifiedWithConditions_ConditionsMatchExclude_Excluded(): void
    {
        $conditionsTest = ['methods' => 'post'];

        $included = StringGuard::isIncluded('exclude_x', $conditionsTest, $this->config, false);
        $this->assertFalse($included);
    }

    /**
     * @test
     * @group StringGuard
     */
    public function ExcludeSpecifiedWithConditions_ConditionsUnMatchExclude_Include(): void
    {
        $conditionsTest = ['methods' => 'posty'];

        $included = StringGuard::isIncludedOrUnspecified('exclude_x', $conditionsTest, $this->config);
        $this->assertTrue($included);
    }

    /**
     * @test
     * @group StringGuard
     */
    public function IncludeSpecified_GetData_Success(): void
    {
        $conditionsTest = ['methods' => 'post'];

        $includedData = StringGuard::getData('include_x', $conditionsTest, $this->config);
        $this->assertEquals($includedData['TEST'], 'TEST');
    }

    //---------- HELPERS ----------
    private function makeConfig(): array
    {
        $conditions = [
            'methods' => ['post', 'delete'],
        ];

        $data = ['test' => 'test'];

        return [
            'include' => [
                StringGuardConfig::make('include_*', $conditions, $data),
            ],
            'exclude' => [
                StringGuardConfig::make('exclude_*', $conditions, $data),
            ],
        ];

    }
}
