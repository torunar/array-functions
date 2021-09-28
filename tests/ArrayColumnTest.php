<?php

namespace Tests\Torunar\ArrayFunctions;

use PHPUnit\Framework\TestCase;

class ArrayColumnTest extends TestCase
{
    public function getDataForTestFallback()
    {
        return [
            [
                [],
                null,
                null,
            ],
            [
                ['a', 'b', 'c'],
                null,
                null,
            ],
            [
                [
                    10 => 'a',
                    20 => 'b',
                    30 => 'c',
                ],
                null,
                null,
            ],
            [
                [
                    'a' => 'A',
                    'b' => 'B',
                    'c' => 'C',
                ],
                null,
                null,
            ],
            [
                [
                    ['key' => 'a', 'val' => 'A'],
                    ['key' => 'b', 'val' => 'B'],
                    ['key' => 'c', 'val' => 'C'],
                ],
                'val',
                null,
            ],
            [
                [
                    ['key' => 'a', 'val' => 'A'],
                    ['key' => 'b', 'val' => 'B'],
                    ['key' => 'c', 'val' => 'C'],
                ],
                'val',
                'key',
            ],
            [
                [
                    ['key' => 1, 'val' => 'A', 'partial_val' => 'partial-A', 'partial_string_key' => 'one'],
                    ['key' => 2, 'val' => 'B', 'partial_numeric_key' => 2],
                    ['key' => 3, 'val' => 'C'],
                ],
                '__no_column',
                null
            ],
            [
                [
                    ['key' => 1, 'val' => 'A', 'partial_val' => 'partial-A', 'partial_string_key' => 'one'],
                    ['key' => 2, 'val' => 'B', 'partial_numeric_key' => 2],
                    ['key' => 3, 'val' => 'C'],
                ],
                'val',
                '__no_index'
            ],
            [
                [
                    ['key' => 1, 'val' => 'A', 'partial_val' => 'partial-A', 'partial_string_key' => 'one'],
                    ['key' => 2, 'val' => 'B', 'partial_numeric_key' => 2],
                    ['key' => 3, 'val' => 'C'],
                ],
                'partial_val',
                null
            ],
            [
                [
                    ['key' => 1, 'val' => 'A', 'partial_val' => 'partial-A', 'partial_string_key' => 'one'],
                    ['key' => 2, 'val' => 'B', 'partial_numeric_key' => 2],
                    ['key' => 3, 'val' => 'C'],
                ],
                'val',
                'partial_string_key'
            ],
            [
                [
                    ['key' => 1, 'val' => 'A', 'partial_val' => 'partial-A', 'partial_string_key' => 'one'],
                    ['key' => 2, 'val' => 'B', 'partial_numeric_key' => 2],
                    ['key' => 3, 'val' => 'C'],
                ],
                'val',
                'partial_numeric_key'
            ],
        ];
    }

    public function getDataForTestGeneral()
    {
        return [
            [
                [],
                static function () { return null; },
                null,
                [],
            ],
            [
                [],
                null,
                static function () { return null; },
                [],
            ],
            [
                [],
                static function () { return null; },
                static function () { return null; },
                [],
            ],

            [
                ['a', 'b', 'c'],
                static function ($item, $key) { return strtoupper($item); },
                null,
                ['A', 'B', 'C'],
            ],
            [
                ['a', 'b', 'c'],
                null,
                static function ($item, $key) { return ($key + 1) * 10; },
                [10 => 'a', 20 => 'b', 30 => 'c'],
            ],
            [
                ['a', 'b', 'c'],
                static function ($item, $key) { return strtoupper($item); },
                static function ($item, $key) { return ($key + 1) * 10; },
                [10 => 'A', 20 => 'B', 30 => 'C'],
            ],

            [
                [
                    10 => 'a',
                    20 => 'b',
                    30 => 'c',
                ],
                static function ($item, $key) { return strtoupper($item); },
                null,
                [10 => 'A', 20 => 'B', 30 => 'C'],
            ],
            [
                [
                    10 => 'a',
                    20 => 'b',
                    30 => 'c',
                ],
                null,
                static function ($item, $key) { return $key * 10; },
                [100 => 'a', 200 => 'b', 300 => 'c'],
            ],
            [
                [
                    10 => 'a',
                    20 => 'b',
                    30 => 'c',
                ],
                static function ($item, $key) { return strtoupper($item); },
                static function ($item, $key) { return $key * 10; },
                [100 => 'A', 200 => 'B', 300 => 'C'],
            ],

            [
                [
                    'a' => 'A',
                    'b' => 'B',
                    'c' => 'C',
                ],
                static function ($item, $key) { return $key . $item; },
                null,
                [
                    'a' => 'aA',
                    'b' => 'bB',
                    'c' => 'cC',
                ],
            ],
            [
                [
                    'a' => 'A',
                    'b' => 'B',
                    'c' => 'C',
                ],
                null,
                static function ($item, $key) { return $key . $item; },
                [
                    'aA' => 'A',
                    'bB' => 'B',
                    'cC' => 'C',
                ],
            ],
            [
                [
                    'a' => 'A',
                    'b' => 'B',
                    'c' => 'C',
                ],
                static function ($item, $key) { return $key . $item; },
                static function ($item, $key) { return $key . $item; },
                [
                    'aA' => 'aA',
                    'bB' => 'bB',
                    'cC' => 'cC',
                ],
            ],

            [
                [
                    ['key' => ['numeric' => 10, 'display' => '#10'], 'val' => 'A'],
                    ['key' => ['numeric' => 20, 'display' => '#20'], 'val' => 'B'],
                    ['key' => ['numeric' => 30, 'display' => '#30'], 'val' => 'C'],
                ],
                static function ($item, $key) { return $item['val']; },
                null,
                ['A', 'B', 'C'],
            ],
            [
                [
                    ['key' => ['numeric' => 10, 'display' => '#10'], 'val' => 'A'],
                    ['key' => ['numeric' => 20, 'display' => '#20'], 'val' => 'B'],
                    ['key' => ['numeric' => 30, 'display' => '#30'], 'val' => 'C'],
                ],
                static function ($item, $key) { return $item['val']; },
                'val',
                ['A' => 'A', 'B' => 'B', 'C' => 'C'],
            ],
            [
                [
                    ['key' => ['numeric' => 10, 'display' => '#10'], 'val' => 'A'],
                    ['key' => ['numeric' => 20, 'display' => '#20'], 'val' => 'B'],
                    ['key' => ['numeric' => 30, 'display' => '#30'], 'val' => 'C'],
                ],
                null,
                static function ($item, $key) { return $item['key']['numeric']; },
                [
                    10 => ['key' => ['numeric' => 10, 'display' => '#10'], 'val' => 'A'],
                    20 => ['key' => ['numeric' => 20, 'display' => '#20'], 'val' => 'B'],
                    30 => ['key' => ['numeric' => 30, 'display' => '#30'], 'val' => 'C'],
                ],
            ],
            [
                [
                    ['key' => ['numeric' => 10, 'display' => '#10'], 'val' => 'A'],
                    ['key' => ['numeric' => 20, 'display' => '#20'], 'val' => 'B'],
                    ['key' => ['numeric' => 30, 'display' => '#30'], 'val' => 'C'],
                ],
                'val',
                static function ($item, $key) { return $item['key']['numeric']; },
                [
                    10 => 'A',
                    20 => 'B',
                    30 => 'C',
                ],
            ],
            [
                [
                    ['key' => ['numeric' => 10, 'display' => '#10'], 'val' => 'A'],
                    ['key' => ['numeric' => 20, 'display' => '#20'], 'val' => 'B'],
                    ['key' => ['numeric' => 30, 'display' => '#30'], 'val' => 'C'],
                ],
                static function ($item, $key) { return $item['key']['display'] . ': ' . $item['val']; },
                static function ($item, $key) { return $item['key']['numeric']; },
                [
                    10 => '#10: A',
                    20 => '#20: B',
                    30 => '#30: C',
                ],
            ],
            [
                [
                    100 => ['key' => ['numeric' => 10, 'display' => '#10'], 'val' => 'A'],
                    200 => ['key' => ['numeric' => 20, 'display' => '#20'], 'val' => 'B'],
                    300 => ['key' => ['numeric' => 30, 'display' => '#30'], 'val' => 'C'],
                ],
                static function ($item, $key) { return $item['val']; },
                null,
                [
                    100 => 'A',
                    200 => 'B',
                    300 => 'C',
                ],
            ],
        ];
    }

    /**
     * @dataProvider getDataForTestFallback
     */
    public function testFallback($array, $column_key, $index_key)
    {
        $this->assertEquals(
            \array_column($array, $column_key, $index_key),
            \Torunar\array_column($array, $column_key, $index_key)
        );
    }

    /**
     * @dataProvider getDataForTestGeneral
     */
    public function testGeneral($array, $column_key, $index_key, $expected)
    {
        $this->assertEquals(
            $expected,
            \Torunar\array_column($array, $column_key, $index_key)
        );
    }
}
