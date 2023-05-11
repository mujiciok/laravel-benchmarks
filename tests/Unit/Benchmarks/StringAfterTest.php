<?php

namespace Tests\Unit\Benchmarks;

use App\Benchmarks\BenchmarkServiceInterface;
use App\Benchmarks\StringAfter\StringAfter;

class StringAfterTest extends BenchmarkTestCase
{
    private readonly StringAfter $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = $this->app->make(StringAfter::class);
    }

    public function getMethods(): array
    {
        return [
            'getUsingStr' => 'Str::after',
            'getUsingFluentStr' => 'Str::of()->after',
            'getUsingRegex' => 'preg_replace',
            'getUsingPlainPhpV1' => 'array_reverse & explode',
            'getUsingPlainPhpV2' => 'substr & strpos',
        ];
    }

    public function getBenchmarkService(): BenchmarkServiceInterface
    {
        return $this->service;
    }

    public function getBenchmarkTitle(): string
    {
        return '### `Str::after` vs `Str::of()->after` vs `preg_replace` vs `explode` vs `substr`';
    }

    /**
     * @dataProvider providesBenchmarkTestCases
     *
     * @param string $subject
     * @param string $search
     * @return void
     */
    public function testBenchmark(string $subject, string $search): void
    {
        $this->benchmark($subject, $search);
    }

    public function providesBenchmarkTestCases(): array
    {
        return [
            [
                'haystack' => 'Some random string for test and one more string repeated',
                'needle' => 'string',
            ],
            [
                'haystack' => 'Sed elit nunc, auctor ac elit at, mattis blandit purus. Nam fermentum tortor eget ipsum gravida rutrum. Cras eget purus egestas, feugiat lorem at, iaculis arcu. Vivamus venenatis hendrerit velit ut ultricies. Vestibulum eu vulputate elit, id sodales neque. Duis imperdiet ante in nisi pellentesque varius. Suspendisse potenti. Maecenas hendrerit, mauris non sollicitudin viverra, tellus metus vestibulum nulla, non porta mi enim sit amet nulla. Sed turpis ex, semper nec mollis ut, lacinia at sapien. Quisque vitae magna accumsan, vestibulum eros sit amet, eleifend nibh. Curabitur arcu neque, convallis sed ornare sed, pretium eu erat. Nunc elit purus, gravida sit amet porta accumsan, rutrum non est. Vivamus dapibus enim sed pharetra mattis. Suspendisse luctus dolor et urna condimentum, sed condimentum elit placerat. Ut et turpis a nisl feugiat interdum.',
                'needle' => 'arcu. ',
            ],
        ];
    }

    /**
     * @dataProvider providesTestCases
     *
     * @param string $subject
     * @param string $search
     * @param string $expectedResult
     * @return void
     */
    public function testValidation(string $subject, string $search, string $expectedResult): void
    {
        $this->validate($expectedResult, $subject, $search);
    }

    public function providesTestCases(): array
    {
        return [
            'single character' => [
                'haystack' => 'Some random string for test',
                'needle' => 'r',
                'result' => 'andom string for test',
            ],
//            'space' => [
//                'haystack' => 'Some random string for test',
//                'needle' => ' ',
//                'result' => 'random string for test',
//            ],
//            'multiple characters' => [
//                'haystack' => 'Some random string for test',
//                'needle' => 'for',
//                'result' => ' test',
//            ],
//            'multiple occurrences' => [
//                'haystack' => 'Some random string for test and one more string repeated',
//                'needle' => 'string',
//                'result' => ' for test and one more string repeated',
//            ],
//            'long string' => [
//                'haystack' => 'Sed elit nunc, auctor ac elit at, mattis blandit purus. Nam fermentum tortor eget ipsum gravida rutrum. Cras eget purus egestas, feugiat lorem at, iaculis arcu. Vivamus venenatis hendrerit velit ut ultricies. Vestibulum eu vulputate elit, id sodales neque. Duis imperdiet ante in nisi pellentesque varius. Suspendisse potenti. Maecenas hendrerit, mauris non sollicitudin viverra, tellus metus vestibulum nulla, non porta mi enim sit amet nulla. Sed turpis ex, semper nec mollis ut, lacinia at sapien. Quisque vitae magna accumsan, vestibulum eros sit amet, eleifend nibh. Curabitur arcu neque, convallis sed ornare sed, pretium eu erat. Nunc elit purus, gravida sit amet porta accumsan, rutrum non est. Vivamus dapibus enim sed pharetra mattis. Suspendisse luctus dolor et urna condimentum, sed condimentum elit placerat. Ut et turpis a nisl feugiat interdum.',
//                'needle' => 'arcu. ',
//                'result' => 'Vivamus venenatis hendrerit velit ut ultricies. Vestibulum eu vulputate elit, id sodales neque. Duis imperdiet ante in nisi pellentesque varius. Suspendisse potenti. Maecenas hendrerit, mauris non sollicitudin viverra, tellus metus vestibulum nulla, non porta mi enim sit amet nulla. Sed turpis ex, semper nec mollis ut, lacinia at sapien. Quisque vitae magna accumsan, vestibulum eros sit amet, eleifend nibh. Curabitur arcu neque, convallis sed ornare sed, pretium eu erat. Nunc elit purus, gravida sit amet porta accumsan, rutrum non est. Vivamus dapibus enim sed pharetra mattis. Suspendisse luctus dolor et urna condimentum, sed condimentum elit placerat. Ut et turpis a nisl feugiat interdum.',
//            ],
//            'empty needle' => [
//                'haystack' => 'Hello World',
//                'needle' => '',
//                'result' => 'Hello World',
//            ],
//            'missing' => [
//                'haystack' => 'Hello World',
//                'needle' => '9',
//                'result' => 'Hello World',
//            ],
        ];
    }
}
