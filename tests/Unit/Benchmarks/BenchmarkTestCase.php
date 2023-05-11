<?php

namespace Tests\Unit\Benchmarks;

ini_set('max_execution_time', 600);

use App\Benchmarks\BenchmarkServiceInterface;
use Illuminate\Support\Benchmark;
use Tests\TestCase;
use Tests\Unit\LoggableTrait;

abstract class BenchmarkTestCase extends TestCase
{
    use LoggableTrait;

    /**
     * @return array<string, string>
     */
    abstract public function getMethods(): array;

    abstract public function getBenchmarkService(): BenchmarkServiceInterface;

    abstract public function getBenchmarkTitle(): string;

    /**
     * @return array<int, string>
     */
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

    public function validate(bool $expectedResult, ...$methodCallArgs): void
    {
        $methods = $this->getMethods();
        $service = $this->getBenchmarkService();

        foreach ($methods as $methodName => $methodTableName) {
            $actualResult = $service->{$methodName}(...$methodCallArgs);
            $this->assertEquals($expectedResult, $actualResult, $methodName);
        }
    }

    public function benchmark(...$methodCallArgs): void
    {
        $logData = [];
        $methodsData = $this->getMethods();
        $iterationsData = $this->getIterations();
        $service = $this->getBenchmarkService();

        foreach ($methodsData as $methodName => $rowHeading) {
            foreach ($iterationsData as $iterations => $columnHeading) {
                $logData[$rowHeading][$columnHeading] =
                    Benchmark::measure(fn() => $service->{$methodName}(...$methodCallArgs), $iterations);
            }
        }

        $this->logTable($logData);

        $this->assertTrue(true);
    }
}
