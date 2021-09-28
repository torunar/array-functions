<?php

namespace Torunar;

/**
 * Returns the values from a single column in the input array.
 *
 * @param array                    $array      A multi-dimensional array (record set) from which to pull a column of
 *                                             values.
 * @param string|int|callable      $column_key The column of values to return. This value may be the integer key of the
 *                                             column you wish to retrieve, the string key name, or a callback that
 *                                             retrieves value from a record. It may also be NULL to return complete
 *                                             arrays (useful together with index_key to reindex the array).
 * @param string|int|callable|null $index_key  The column to use as the index/keys for the returned array. This value
 *                                             may be the integer key of the column, the string key name, or a callback
 *                                             that retrieves the key from a record.
 *
 * @return array
 */
function array_column(array $array, $column_key, $index_key = null)
{
    if (
        (
            $column_key === null
            || is_string($column_key)
            || is_int($column_key)
        ) && (
            $index_key === null
            || is_string($index_key)
            || is_int($index_key)
        )
    ) {
        return \array_column($array, $column_key, $index_key);
    }

    $rebuilt_array = [];
    foreach ($array as $key => $item) {
        $rebuilt_key = null;
        if ($index_key === null) {
            $rebuilt_key = $key;
        } elseif (is_string($index_key) || is_int($index_key)) {
            $rebuilt_key = $item[$index_key];
        } else {
            $rebuilt_key = $index_key($item, $key);
        }

        $rebuilt_value = null;
        if ($column_key === null) {
            $rebuilt_value = $item;
        } elseif (is_string($column_key) || is_int($column_key)) {
            $rebuilt_value = $item[$column_key];
        } else {
            $rebuilt_value = $column_key($item, $key);
        }

        $rebuilt_array[$rebuilt_key] = $rebuilt_value;
    }

    return $rebuilt_array;
}
