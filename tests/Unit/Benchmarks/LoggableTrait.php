<?php

namespace Tests\Unit\Benchmarks;

use Illuminate\Support\Arr;

trait LoggableTrait
{
    /**
     * @param array<string, array<string, mixed>> $data
     * @return void
     */
    protected function logTable(array $data): void
    {
        $tableData = $this->convertToTableStructure($data);

        $maxColSizes = $this->getMaxColumnSizes($tableData);
        $colDelimiter = '|';

        $logText = PHP_EOL . $this->getBenchmarkTitle() . PHP_EOL . PHP_EOL;

        foreach ($tableData as $r => $row) {
            $logText .= $colDelimiter;

            foreach ($row as $c => $column) {
                $logText .= str_pad($column, $maxColSizes[$c] + 1, ' ', STR_PAD_LEFT) . ' ';

                $logText .= $colDelimiter;
            }

            $logText .= PHP_EOL;

            if ($r === 0) {
                $logText .= $this->getHeadingRowDelimiter($maxColSizes);
            }
        }

        info($logText);
    }

    /**
     * @param array<string, array<string, mixed>> $data
     * @return array<int, array<int, mixed>>
     */
    private function convertToTableStructure(array $data): array
    {
        $table = [];
        $columnHeaders = array_keys(Arr::first($data));

        $table[] = ['', ...$columnHeaders];

        foreach ($data as $key => $values) {
            $table[] = [$key, ...array_values($values)];
        }

        return $table;
    }

    /**
     * @param array<int, array<int, mixed>> $tableData
     * @return array<int>
     */
    private function getMaxColumnSizes(array $tableData): array
    {
        $maxSizes = [];

        foreach ($tableData as $row) {
            foreach ($row as $colId => $columnValue) {
                $maxSizes[$colId] = max($maxSizes[$colId] ?? 0, strlen($columnValue));
            }
        }

        return $maxSizes;
    }

    /**
     * @param array<int> $maxColSizes
     * @return string
     */
    private function getHeadingRowDelimiter(array $maxColSizes): string
    {
        $delimiter = '|';

        foreach ($maxColSizes as $colSize) {
            // + 2 for spaces around column value
            $delimiter .= str_pad('', $colSize + 2, '-') . '|';
        }

        return $delimiter . PHP_EOL;
    }
}
