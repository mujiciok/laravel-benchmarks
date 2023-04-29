<?php

declare(strict_types=1);

namespace App\Benchmarks\Regex\StringContainsCaseInsensitive;

use App\Benchmarks\BenchmarkServiceInterface;
use Illuminate\Support\Str;

class StringContainsCaseInsensitive implements BenchmarkServiceInterface
{
    public function matchUsingStr(string $haystack, string $needle): bool
    {
        return Str::contains($haystack, $needle, true);
    }

    public function matchUsingRegex(string $haystack, string $needle): bool
    {
        if (!$needle) {
            return false;
        }

        return (bool)preg_match("/$needle/i", $haystack);
    }

    public function matchUsingPlainPhp(string $haystack, string $needle): bool
    {
        if (!$needle) {
            return false;
        }

        $haystack = strtolower($haystack);
        $needle = strtolower($needle);

        return str_contains($haystack, $needle);
    }
}
