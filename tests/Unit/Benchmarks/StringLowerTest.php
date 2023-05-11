<?php

namespace Tests\Unit\Benchmarks;

use App\Benchmarks\BenchmarkServiceInterface;
use App\Benchmarks\StringLower\StringLower;

class StringLowerTest extends BenchmarkTestCase
{
    private readonly StringLower $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = $this->app->make(StringLower::class);
    }

    public function getMethods(): array
    {
        return [
            'convertUsingStr' => 'Str::lower',
            'convertUsingFluentStr' => 'Str::of()->lower',
            'convertUsingPlainPhp' => 'strtolower',
        ];
    }

    public function getBenchmarkService(): BenchmarkServiceInterface
    {
        return $this->service;
    }

    public function getBenchmarkTitle(): string
    {
        return '### `Str::lower` vs `Str::of()->lower` vs `strtolower`';
    }

    /**
     * @dataProvider providesBenchmarkTestCases
     *
     * @param string $value
     * @return void
     */
    public function testBenchmark(string $value): void
    {
        $this->benchmark($value);
    }

    public function providesBenchmarkTestCases(): array
    {
        return [
            [
                'value' => 'A string Containing BOTH lowerCase and upperCase',
            ],
        ];
    }

    /**
     * @dataProvider providesTestCases
     *
     * @param string $haystack
     * @param string $needle
     * @param bool $expectedResult
     * @return void
     */
    public function testValidation(string $value, string $expectedResult): void
    {
        $this->validate($value, $expectedResult);
    }

    public function providesTestCases(): array
    {
        return [
            'single word' => [
                'value' => 'TestWord',
                'result' => 'testword',
            ],
            'multiple words' => [
                'value' => 'A string Containing BOTH lowerCase and upperCase',
                'result' => 'a string containing both lowercase and uppercase',
            ],
            'empty string' => [
                'value' => '',
                'result' => '',
            ],
        ];
    }
}
