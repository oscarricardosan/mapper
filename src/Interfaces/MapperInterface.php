<?php

namespace Oscarricardosan\Mapper\Interfaces;


interface MapperInterface
{
    public function __construct(array $attributes = []);

    public function setAttributesFromArray(array $attributes = []);

    public function getAttributes();

    public function __get($name);

    public function __set($name, $value);

}