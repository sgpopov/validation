# PHP Validation Library

[![Build Status](https://travis-ci.org/svil4ok/validation.svg?branch=master)](https://travis-ci.org/svil4ok/validation)

Simple and lightweight standalone PHP library for validating data.

## Usage

````php
<?php

use SGP\Validation\Validator;

$input = [
    'name' => 'Svilen Popov',
    'comment' => 'This a comment',
    'users' => [
        [
            'age' => 20,
            'username' => 'username1'
        ],
        [
            'age' => 16,
            'username' => 'username2'
        ]
    ]
];

$rules = [
    'name' => 'required',
    'comment' => 'required|min:20',
    'users.*.age' => 'required|min:18'
];

$messages = [
    'comment.min' => 'Your comment should have at least 20 chars.'
];

$validator = Validator::make($input, $rules, $messages);

$errors = $validator->errors()->all();

foreach ($errors as $error) {
    echo $error . PHP_EOL;
}
````

and the above example will output:

```
Your comment should have at least 20 chars.
The users.1.age minimum is 18
```

## Available rules

| <a href="#rule_alpha"><strong>Alpha</strong></a> | <a href="#rule_int"><strong>Integer</strong></a> |
|:---------------------------------|:---------------------------------|
| <a href="#rule_alpha_numeric"><strong>Alpha-Numeric</strong></a> | <a href="#rule_max"><strong>Max</strong></a> |
| <a href="#rule_boolean"><strong>Boolean</strong></a> | <a href="#rule_min"><strong>Min</strong></a> |
| <a href="#rule_date_after"><strong>Date after</strong></a> | <a href="#rule_numeric"><strong>Numeric</strong></a> |
| <a href="#rule_date_before"><strong>Date before</strong></a> | <a href="#rule_required"><strong>Required</strong></a> |
| <a href="#rule_date"><strong>Date</strong></a> | |

----

<div id="rule_alpha">- <strong>alpha</strong></div>

Checks if the value contains only alphabetic characters.

```php
'field' => 'alpha'
```

<div id="rule_alpha_numeric">- <strong>alpha_num</strong></div>

Checks if the valuecontains only alpha-numeric characters.

```php
'field' => 'alpha_num'
```

<div id="rule_boolean">- <strong>boolean</strong></div>

Checks if the value is able to be cast as a boolean. Accepted input are `true`, `false`, `1`, `0`, `"1"`, and `"0"`.

```php
'field' => 'boolean'
```

<div id="rule_date_after">- <strong>date_after:<em>param</em></strong></div>

Checks if the value is a valid date and is after a given date.

```php
'field' => 'date_after:2017-01-01'
```

<div id="rule_date_before">- <strong>date_before:<em>param</em></strong></div>

Checks if the value is a valid date and is before a given date.

```php
'field' => 'date_before:2017-01-01'
```

<div id="rule_date">- <strong>date</strong></div>

Checks if the value is a date/time string in the input format.

```php
'field' => 'date'
```

<div id="rule_int">- <strong>max:<em>int</em></strong></div>

Checks if the value is an integer.

```php
'field' => 'int'
```

<div id="rule_max">- <strong>max:<em>param</em></strong></div>

Checks if the value is less than given size. The rule works for strings, numerics and arrays.

```php
'field' => 'max:20'
```

<div id="rule_min">- <strong>min:<em>param</em></strong></div>

Checks if the value is greater than given size. The rule works for strings, numerics and arrays.

```php
'field' => 'max:20'
```

<div id="rule_numeric">- <strong>max:<em>numeric</em></strong></div>

Checks if the value is numeric.

```php
'field' => 'numeric'
```

<div id="rule_required">- <strong>required</strong></div>

Checks if the value is not empty or null.

```php
'field' => 'required'
```
