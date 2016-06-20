# tt-vault
Vault for private keys and secret data

[![Build Status](https://travis-ci.org/necromant2005/tt-vault.svg?branch=master)](https://travis-ci.org/necromant2005/tt-vault)



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
    "necromant2005/tt-vault": "*",
}
```

2. Now tell composer to download Twee\Service\Vault by running the command:

```bash
$ php composer.phar update
```

#### Usage

```php
$vault = new Vault('path/to/vault.php');
$vault->get('my-token'); // ['abc' => 123]
$vault->get('non-exist'); // []
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