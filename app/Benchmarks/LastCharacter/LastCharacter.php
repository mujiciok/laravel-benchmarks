<?php

declare(strict_types=1);

namespace App\Benchmarks\LastCharacter;

use App\Benchmarks\BenchmarkServiceInterface;
use Illuminate\Support\Str;

class LastCharacter implements BenchmarkServiceInterface
{
    public function matchUsingStr(string $haystack, string $needle): bool
    {
        return Str::endsWith($haystack, $needle);
    }

    public function matchUsingFluentStr(string $haystack, string $needle): bool
    {
        return Str::of($haystack)->endsWith($needle);
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
