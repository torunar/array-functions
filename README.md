# Array functions

Set of functions to operate the most glorious PHP data structure.

## Installation

```bash
$ composer require torunar/array-functions
```

## Functions

### array_column

Works as the regular [`array_column`](https://www.php.net/manual/en/function.array-column.php) function, but supports column value and index extraction via data providers.

Example:
```php

<?php

$data_from_api = [
    [
        'currency' => [
            'code' => 'EUR',
        ],
        'amount' => [
            'value' => 42.00,
        ],
    ],
    [
        'currency' => [
            'code' => 'USD',
        ],
        'amount' => [
            'value' => 53.00,
        ],
    ],
    [
        'currency' => [
            'code' => 'JPY',
        ],
        'amount' => [
            'value' => 5300,
        ],
    ],
];

$necessary_data = \Torunar\array_column(
    $data_from_api,
    static function ($item, $key) {
        return $item['amount']['value'];
    },
    static function ($item, $key) {
        return $item['currency']['code'];
    }
);

var_dump(
    $necessary_data
);
```

Output:
```
array(3) {
  ["EUR"]=>
  float(42)
  ["USD"]=>
  float(53)
  ["JPY"]=>
  int(5300)
}
```


