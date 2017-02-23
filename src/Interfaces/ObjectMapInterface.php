<?php

namespace Oscarsan\ObjectMap\Interfaces;


interface ObjectMapInterface
{
    public function __construct(array $attributes = []);

    public function setAttributesArray(array $attributes = []);

    public function getAttributes();

}