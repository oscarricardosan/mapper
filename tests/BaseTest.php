<?php

namespace Oscarricardosan\Mapper\Tests;

abstract class BaseTest extends \PHPUnit_Framework_TestCase
{
    public function assertArrayHasKeys(array $array, array $expectedKeys){
        foreach ($expectedKeys as $key)
            $this->assertArrayHasKey($key, $array);
    }
}