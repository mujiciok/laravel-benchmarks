<?php

namespace Tests\Unit\Benchmarks;

use App\Benchmarks\BenchmarkServiceInterface;
use App\Benchmarks\StringContainsCaseInsensitive\StringContainsCaseInsensitive;

class StringContainsCaseInsensitiveTest extends BenchmarkTestCase
{
    private readonly StringContainsCaseInsensitive $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = $this->app->make(StringContainsCaseInsensitive::class);
    }

    public function getIterations(): array
    {
        return [
            10 => 'x10',
            100 => 'x100',
            1_000 => 'x1_000',
            10_000 => 'x10_000',
            100_000 => 'x100_000',
            1_000_000 => 'x1_000_000',
        ];
    }

    public function getMethods(): array
    {
        return [
            'matchUsingStr' => 'Str::contains',
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
        return '### Case insensitive `Str::contains` vs `preg_match` vs `str_contains`';
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
                'needle' => 'AND',
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
        $this->validate($haystack, $needle, $expectedResult);
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
                'result' => true,
            ],
            'mixed needle case' => [
                'haystack' => 'Some text and some more',
                'needle' => 'aNd',
                'result' => true,
            ],
            'mixed haystack case' => [
                'haystack' => 'Some text AnD some more',
                'needle' => 'and',
                'result' => true,
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
