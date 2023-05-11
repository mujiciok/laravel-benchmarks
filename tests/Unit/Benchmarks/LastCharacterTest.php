<?php

namespace Tests\Unit\Benchmarks;

use App\Benchmarks\BenchmarkServiceInterface;
use App\Benchmarks\LastCharacter\LastCharacter;

class LastCharacterTest extends BenchmarkTestCase
{
    private readonly LastCharacter $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = $this->app->make(LastCharacter::class);
    }

    public function getMethods(): array
    {
        return [
            'matchUsingStr' => 'Str::endsWith',
            'matchUsingFluentStr' => 'Str::of()->endsWith',
            'matchUsingRegex' => 'preg_match',
            'matchUsingPlainPhp' => 'str_ends_with',
        ];
    }

    public function getBenchmarkService(): BenchmarkServiceInterface
    {
        return $this->service;
    }

    public function getBenchmarkTitle(): string
    {
        return '### `Str::endsWith` vs `Str::of()->endsWith` vs `preg_match` vs `str_ends_with`';
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
                'haystack' => 'Hello World',
                'needle' => 'd',
            ],
            [
                'haystack' => 'Hello World',
                'needle' => 'rld',
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
            'single character' => [
                'haystack' => 'Hello World',
                'needle' => 'd',
                'result' => true,
            ],
            'multiple characters' => [
                'haystack' => 'Hello World',
                'needle' => 'rld',
                'result' => true,
            ],
            'single character different case' => [
                'haystack' => 'Hello World',
                'needle' => 'D',
                'result' => false,
            ],
            'multiple characters different case' => [
                'haystack' => 'Hello World',
                'needle' => 'rLd',
                'result' => false,
            ],
            'empty needle' => [
                'haystack' => 'Hello World',
                'needle' => '',
                'result' => false,
            ],
            'missing' => [
                'haystack' => 'Hello World',
                'needle' => 'l',
                'result' => false,
            ],
        ];
    }
}
