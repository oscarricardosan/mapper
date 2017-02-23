<?php

namespace Oscarsan\ObjectMap\Tests\ExamplesClasses;

use Oscarsan\ObjectMap\ObjectMap;

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