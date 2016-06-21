<?php
namespace Twee\Service;

use DomainException;
use OutOfRangeException;
use InvalidArgumentException;

class Vault
{
    const VAULT = 'vault';

    private $filename = '';

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function get(string $key) : array
    {
        if (!file_exists($this->filename)) {
            throw new DomainException('File "' . $this->filename . '" does not exist');
        }

        $data = include $this->filename;

        if (!is_array($data) || !array_key_exists(self::VAULT, $data) || !is_array($data[self::VAULT])) {
            throw new OutOfRangeException('Vault has incorrect format. Excepted <?php return ["vault" => [ "token" => "secret-data" ] ];');
        }

        if (!array_key_exists($key, $data[self::VAULT])) {
            throw new InvalidArgumentException('Key "' . $key . '" does not exist');
        }

        return (array) $data[self::VAULT][$key];
    }
}