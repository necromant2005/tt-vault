# tt-vault
Vault for private keys and secret data

[![Build Status](https://travis-ci.org/truesocialmetrics/vault.svg?branch=master)](https://travis-ci.org/truesocialmetrics/vault)



tt-vault
=======
Created by Rostislav Mykhajliw

Introduction
------------

Twee\Service\Vault is a simple vault for storing private keys/tokens and pther secret data


Features / Goals
----------------

* Secure store data on filesystem
* Simple access
* Errors and leaks protections

Installation
------------

### Main Setup

#### With composer

1. Add this to your composer.json:

```json
"require": {
    "truesocialmetrics/vault": "*",
}
```

2. Now tell composer to download Twee\Service\Vault by running the command:

```bash
$ php composer.phar update
```

#### Usage

```php
$vault = new Vault\File('path/to/vault.php');
$vault->get('my-token'); // ['abc' => 123]
$vault->get('non-exist'); // throw InvalidArgumentException
```

Sample vault.php file
```
<?php
return [
    'vault' => [
        'my-token' => [
            'abc' => 123,
        ],
    ],
];
```

Sample with AWS SSM parameter store
```php
$vault = new Vault\Aws([
    'credentials' => [
        'key'    => '...',
        'secret' => '...',
    ],
    'region'  => 'us-east-1',
    'version' => 'latest',
]);
$vault->get('my-token'); // ['abc' => 123]
$vault->get('non-exist'); // throw InvalidArgumentException
```


