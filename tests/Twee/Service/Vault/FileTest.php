<?php

namespace Twee\Service\Vault;

use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    /**
     * @expectedException DomainException
     */
    public function testDoesNotExit()
    {
        $vault = new File(__DIR__ . '/_files/non-exist-vault.php');
        $vault->get('abc');
    }

    /**
     * @expectedException OutOfRangeException
     */
    public function testInforrectFormat()
    {
        $vault = new File(__DIR__ . '/_files/vault-incorrect-format.php');
        $vault->get('abc');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testKeyDoesNotExist()
    {
        $vault = new File(__DIR__ . '/_files/vault.php');
        $vault->get('non-exist-key');
    }

    public function testGet()
    {
        $vault = new File(__DIR__ . '/_files/vault.php');
        $this->assertEquals(['abc' => 123], $vault->get('secret'));
    }
}
