<?php

namespace Tests\Unit\Benchmarks;

use App\Benchmarks\BenchmarkServiceInterface;
use App\Benchmarks\FirstCharacter\FirstCharacter;

class FirstCharacterTest extends BenchmarkTestCase
{
    private readonly FirstCharacter $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = $this->app->make(FirstCharacter::class);
    }

    public function getMethods(): array
    {
        return [
            'matchUsingStr' => 'Str::startsWith',
            'matchUsingFluentStr' => 'Str::of()->startsWith',
            'matchUsingRegex' => 'preg_match',
            'matchUsingPlainPhp' => 'str_starts_with',
        ];
    }

    public function getBenchmarkService(): BenchmarkServiceInterface
    {
        return $this->service;
    }

    public function getBenchmarkTitle(): string
    {
        return '### `Str::startsWith` vs `Str::of()->startsWith` vs `preg_match` vs `str_starts_with`';
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
                'needle' => 'H',
            ],
            [
                'haystack' => 'Hello World',
                'needle' => 'Hel',
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
                'needle' => 'H',
                'result' => true,
            ],
            'multiple characters' => [
                'haystack' => 'Hello World',
                'needle' => 'Hel',
                'result' => true,
            ],
            'single character different case' => [
                'haystack' => 'Hello World',
                'needle' => 'h',
                'result' => false,
            ],
            'multiple characters different case' => [
                'haystack' => 'Hello World',
                'needle' => 'HEL',
                'result' => false,
            ],
            'empty needle' => [
                'haystack' => 'Hello World',
                'needle' => '',
                'result' => false,
            ],
            'missing' => [
                'haystack' => 'Hello World',
                'needle' => 'e',
                'result' => false,
            ],
        ];
    }
}
