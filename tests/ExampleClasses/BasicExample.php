<?php

namespace Oscarricardosan\ObjectMap\Tests\ExamplesClasses;

use Oscarricardosan\ObjectMap\ObjectMap;

class BasicExample extends ObjectMap
{
    public $name = '';
    public $company = 'PHP Company';
    public $document_type;
    public $document_number;
    public $city;
    public $state;
    public $country;
    public $car;
}