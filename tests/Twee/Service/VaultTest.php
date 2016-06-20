<?php

namespace Twee\Service;

use PHPUnit_Framework_TestCase;

class VaultTest extends PHPUnit_Framework_TestCase
{
    public function testDoesNotExit()
    {
        $vault = new Vault(__DIR__ . '/_files/non-exist-vault.php');
        $this->assertEquals([], $vault->get('abc'));
    }

    public function testGet()
    {
        $vault = new Vault(__DIR__ . '/_files/vault.php');
        $this->assertEquals([], $vault->get('abc'));
        $this->assertEquals(['abc' => 123], $vault->get('secret'));
    }
}