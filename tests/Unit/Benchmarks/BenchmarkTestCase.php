<?php

namespace Tests\Unit\Benchmarks;

ini_set('max_execution_time', 300);

use App\Benchmarks\BenchmarkServiceInterface;
use Illuminate\Support\Benchmark;
use Tests\TestCase;

abstract class BenchmarkTestCase extends TestCase
{
    use LoggableTrait;

    /**
     * @return array<int, string>
     */
    abstract public function getIterations(): array;

    /**
     * @return array<string, string>
     */
    abstract public function getMethods(): array;

    abstract public function getBenchmarkService(): BenchmarkServiceInterface;

    abstract public function getBenchmarkTitle(): string;

    public function defaultBenchmarkTest(string $haystack, string $needle): void
    {
        $logData = [];
        $methodsData = $this->getMethods();
        $iterationsData = $this->getIterations();
        $service = $this->getBenchmarkService();

        foreach ($methodsData as $methodName => $rowHeading) {
            foreach ($iterationsData as $iterations => $columnHeading) {
                $logData[$rowHeading][$columnHeading] =
                    Benchmark::measure(fn() => $service->{$methodName}($haystack, $needle), $iterations);
            }
        }

        $this->logTable($logData);

        $this->assertTrue(true);
    }
}
