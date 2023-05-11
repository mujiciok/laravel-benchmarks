<?php

namespace Tests\Unit\Benchmarks;

use App\Benchmarks\BenchmarkServiceInterface;
use App\Benchmarks\StringContains\StringContains;

class StringContainsTest extends BenchmarkTestCase
{
    private readonly StringContains $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = $this->app->make(StringContains::class);
    }

    public function getMethods(): array
    {
        return [
            'matchUsingStr' => 'Str::contains',
            'matchUsingFluentStr' => 'Str::of()->contains',
            'matchUsingRegex' => 'preg_match',
            'matchUsingPlainPhp' => 'str_contains',
        ];
    }

    public function getBenchmarkService(): BenchmarkServiceInterface
    {
        return $this->service;
    }

    public function getBenchmarkTitle(): string
    {
        return '### `Str::contains` vs `Str::of()->contains` vs `preg_match` vs `str_contains`';
    }

    /**
     * @dataProvider providesBenchmarkTestCases
     *
     * @param string $haystack
     * @param string $needle
     * @return void
     */
    public function testBenchmark(string $haystack, string $needle): void
    {
        $this->benchmark($haystack, $needle);
    }

    public function providesBenchmarkTestCases(): array
    {
        return [
            [
                'haystack' => 'Some text and some more',
                'needle' => 'and',
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
    public function testValidation(string $haystack, string $needle, bool $expectedResult): void
    {
        $this->validate($expectedResult, $haystack, $needle);
    }

    public function providesTestCases(): array
    {
        return [
            'same case' => [
                'haystack' => 'Some text and some more',
                'needle' => 'and',
                'result' => true,
            ],
            'different case' => [
                'haystack' => 'Some text and some more',
                'needle' => 'AND',
                'result' => false,
            ],
            'mixed needle case' => [
                'haystack' => 'Some text and some more',
                'needle' => 'aNd',
                'result' => false,
            ],
            'mixed haystack case' => [
                'haystack' => 'Some text AnD some more',
                'needle' => 'and',
                'result' => false,
            ],
            'multiple words' => [
                'haystack' => 'Some text and some more',
                'needle' => 'text and',
                'result' => true,
            ],
            'empty needle' => [
                'haystack' => 'Some text and some more',
                'needle' => '',
                'result' => false,
            ],
            'missing' => [
                'haystack' => 'Some text and some more',
                'needle' => 'word',
                'result' => false,
            ],
        ];
    }
}
