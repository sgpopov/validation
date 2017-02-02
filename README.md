# PHP Validation Library

[![Build Status](https://travis-ci.org/svil4ok/validation.svg?branch=master)](https://travis-ci.org/svil4ok/validation)

Simple and lightweight standalone PHP library for validating data.

## Usage

````php
<?php

use Validation\Validator;

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
    'name.min' => 'Your comment should have at least 20 chars.'
];

$validator = Validator::make($input, $rules, $messages);

$errors = $validator->errors()->all();

foreach ($errors as $error) {
    echo $error . PHP_EOL;
}
````

and the above example will output:

```
TYour name should contain at least 20 chars.
The users.1.age minimum is 18
```

## Available rules

<a href="#rule_boolean">boolean</a> &bull; <a href="#rule_date_after">date_after</a> &bull; <a href="#rule_date_before">date_before</a> &bull;
<a href="#rule_date">date</a> &bull; <a href="#rule_max">max</a> &bull; <a href="#rule_min">min</a> &bull; <a href="#rule_required">required</a>

----

<span id="rule_boolean">- **boolean**</span>

Checks if the value is able to be cast as a boolean. Accepted input are `true`, `false`, `1`, `0`, `"1"`, and `"0"`.

```php
'field' => 'boolean'
```

<span id="rule_date_after">- **date_after:<em>param</em>**</span>

Checks if the value is a valid date and is after a given date.

```php
'field' => 'date_after:2017-01-01'
```

<span id="rule_date_before">- **date_before:<em>param</em>**</span>

Checks if the value is a valid date and is before a given date.

```php
'field' => 'date_before:2017-01-01'
```

<span id="rule_date">- **date**</span>

Checks if the value is a date/time string in the input format.

```php
'field' => 'date'
```

<span id="rule_max">- **max:<em>param</em>**</span>

Checks if the value is less than given size. The rule works for strings, numerics and arrays.

```php
'field' => 'max:20'
```

<span id="rule_min">- **min:<em>param</em>**</span>

Checks if the value is greater than given size. The rule works for strings, numerics and arrays.

```php
'field' => 'max:20'
```

<span id="rule_required">- **required**</span>

Checks if the value is not empty or null.

```php
'field' => 'required'
```
