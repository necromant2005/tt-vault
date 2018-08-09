<?php

namespace Twee\Service\Vault;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use \Aws\Result as AWsResult;

class AwsTest extends TestCase
{
    /**
     * @expectedException DomainException
     */
    public function testConstructWithError()
    {
        $vault = new Aws([]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNonExist()
    {
        $vault = new Aws(['region' => 'us-east-1', 'version' => 'latest']);

        $reflectionClass = new ReflectionClass(Aws::class);
        $property = $reflectionClass->getProperty('client');
        $property->setAccessible(true);

        $stub = $this->createMock(get_class($property->getValue($vault)));
        $stub->method('__call')
             ->willReturn(new AwsResult(['Parameter' => ['Value' => '']]));

        $property->setValue($vault, $stub);

        $vault->get('non-exist');
    }

    /**
     * @expectedException OutOfRangeException
     */
    public function testNonJson()
    {
        $vault = new Aws(['region' => 'us-east-1', 'version' => 'latest']);

        $reflectionClass = new ReflectionClass(Aws::class);
        $property = $reflectionClass->getProperty('client');
        $property->setAccessible(true);

        $stub = $this->createMock(get_class($property->getValue($vault)));
        $stub->method('__call')
             ->willReturn(new AwsResult(['Parameter' => ['Value' => 'ABC']]));

        $property->setValue($vault, $stub);

        $vault->get('non-exist');
    }

    public function test()
    {
        $vault = new Aws(['region' => 'us-east-1', 'version' => 'latest']);

        $reflectionClass = new ReflectionClass(Aws::class);
        $property = $reflectionClass->getProperty('client');
        $property->setAccessible(true);

        $stub = $this->createMock(get_class($property->getValue($vault)));
        $stub->method('__call')
             ->willReturn(new AwsResult(['Parameter' => ['Value' => '{"abc":123}']]));

        $property->setValue($vault, $stub);

        $value = $vault->get('some-key');
        $this->assertEquals(['abc' => 123], $value);
    }
}
