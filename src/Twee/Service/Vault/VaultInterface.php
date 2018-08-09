<?php
namespace Twee\Service\Vault;

use DomainException;
use OutOfRangeException;
use InvalidArgumentException;

interface VaultInterface
{
    public function get(string $key) : array;
}
