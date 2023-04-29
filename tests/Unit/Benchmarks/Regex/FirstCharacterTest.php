<?php

namespace Tests\Unit\Benchmarks\Regex;

use App\Benchmarks\BenchmarkServiceInterface;
use App\Benchmarks\Regex\FirstCharacter;
use Tests\Unit\Benchmarks\BenchmarkTestCase;

class FirstCharacterTest extends BenchmarkTestCase
{
    private readonly FirstCharacter $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = $this->app->make(FirstCharacter::class);
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
            'matchUsingStr' => 'Str::startsWith',
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
        return '#### `Str::startsWith` vs `preg_match` vs `str_starts_with`';
    }

    /**
     * @dataProvider providesMatchTestCases
     *
     * @param string $haystack
     * @param string $needle
     * @return void
     */
    public function testBenchmark(string $haystack, string $needle): void
    {
        $this->defaultBenchmarkTest($haystack, $needle);
    }

    /**
     * @dataProvider providesMatchTestCases
     *
     * @param string $haystack
     * @param string $needle
     * @param bool $result
     * @return void
     */
    public function testMatches(string $haystack, string $needle, bool $result): void
    {
        $strResult = $this->service->matchUsingStr($haystack, $needle);
        $regexResult = $this->service->matchUsingRegex($haystack, $needle);
        $phpResult = $this->service->matchUsingPlainPhp($haystack, $needle);

        $this->assertEquals($result, $strResult);
        $this->assertEquals($result, $regexResult);
        $this->assertEquals($result, $phpResult);
    }

    public function providesMatchTestCases(): array
    {
        return [
            'simple' => [
                'haystack' => 'Hello World',
                'needle' => 'H',
                'result' => true,
            ],
        ];
    }
}
