<?php

declare(strict_types=1);

namespace App\Benchmarks\Regex;

use App\Benchmarks\BenchmarkServiceInterface;
use Illuminate\Support\Str;

class FirstCharacter implements BenchmarkServiceInterface
{
    public function matchUsingStr(string $haystack, string $needle): bool
    {
        return Str::startsWith($haystack, $needle);
    }

    public function matchUsingRegex(string $haystack, string $needle): bool
    {
        return (bool)preg_match("/^$needle/", $haystack);
    }

    public function matchUsingPlainPhp(string $haystack, string $needle): bool
    {
        return str_starts_with($haystack, $needle);
    }
}
