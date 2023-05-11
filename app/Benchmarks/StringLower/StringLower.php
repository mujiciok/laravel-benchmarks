<?php

declare(strict_types=1);

namespace App\Benchmarks\StringLower;

use App\Benchmarks\BenchmarkServiceInterface;
use Illuminate\Support\Str;

class StringLower implements BenchmarkServiceInterface
{
    public function convertUsingStr(string $value): string
    {
        return Str::lower($value);
    }

    public function convertUsingFluentStr(string $value): string
    {
        return Str::of($value)->lower()->value();
    }

    public function convertUsingPlainPhp(string $value): string
    {
        return strtolower($value);
    }
}
