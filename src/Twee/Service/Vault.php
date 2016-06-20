<?php
namespace Twee\Service;

class Vault
{
    const VAULT = 'vault';

    private $filename = '';

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function get(string $key)
    {
        if (!file_exists($this->filename)) {
            return [];
        }

        $data = include $this->filename;

        return array_key_exists($key, $data[self::VAULT]) ? (array) $data[self::VAULT][$key] : [];
    }
}