<?php

declare(strict_types=1);

namespace App\Benchmarks\Regex\LastCharacter;

use App\Benchmarks\BenchmarkServiceInterface;
use Illuminate\Support\Str;

class LastCharacter implements BenchmarkServiceInterface
{
    public function matchUsingStr(string $haystack, string $needle): bool
    {
        return Str::endsWith($haystack, $needle);
    }

    public function matchUsingRegex(string $haystack, string $needle): bool
    {
        if (!$needle) {
            return false;
        }

        return (bool)preg_match("/$needle$/", $haystack);
    }

    public function matchUsingPlainPhp(string $haystack, string $needle): bool
    {
        if (!$needle) {
            return false;
        }

        return str_ends_with($haystack, $needle);
    }
}
