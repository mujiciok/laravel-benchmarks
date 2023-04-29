<?php

declare(strict_types=1);

namespace App\Benchmarks\Regex\StringContains;

use App\Benchmarks\BenchmarkServiceInterface;
use Illuminate\Support\Str;

class StringContains implements BenchmarkServiceInterface
{
    public function matchUsingStr(string $haystack, string $needle): bool
    {
        return Str::contains($haystack, $needle);
    }

    public function matchUsingRegex(string $haystack, string $needle): bool
    {
        if (!$needle) {
            return false;
        }

        return (bool)preg_match("/$needle/", $haystack);
    }

    public function matchUsingPlainPhp(string $haystack, string $needle): bool
    {
        if (!$needle) {
            return false;
        }

        return str_contains($haystack, $needle);
    }
}
