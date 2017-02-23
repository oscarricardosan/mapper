<?php

namespace Oscarricardosan\ObjectMap\Interfaces;


interface ObjectMapInterface
{
    public function __construct(array $attributes = []);

    public function setAttributesFromArray(array $attributes = []);

    public function getAttributes();

    public function __get($name);

    public function __set($name, $value);

}