<?php

declare(strict_types=1);

namespace App\Benchmarks\StringAfter;

use App\Benchmarks\BenchmarkServiceInterface;
use Illuminate\Support\Str;

class StringAfter implements BenchmarkServiceInterface
{
    public function getUsingStr(string $subject, string $search): string
    {
        return Str::after($subject, $search);
    }

    public function getUsingFluentStr(string $subject, string $search): string
    {
        return Str::of($subject)->after($search)->value();
    }

    public function getUsingRegex(string $subject, string $search): string
    {
        if (!$search) {
            return $subject;
        }

        return preg_replace("/^(.*?$search)/", '', $subject);
    }

    public function getUsingPlainPhpV1(string $subject, string $search): string
    {
        if (!$search) {
            return $subject;
        }

        return array_reverse(explode($search, $subject, 2))[0];
    }

    public function getUsingPlainPhpV2(string $subject, string $search): string
    {
        if (!$search) {
            return $subject;
        }

        return substr($subject, strpos($subject, $search) + 1);
    }
}
