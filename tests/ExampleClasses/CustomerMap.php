<?php

namespace Oscarricardosan\ObjectMap\Tests\ExamplesClasses;

use Oscarricardosan\ObjectMap\ObjectMap;

/**
 * @property $name
 * @property $company "PHP Company"
 * @property $document_type
 * @property $document_number
 * @property $city
 * @property $state
 * @property $country
 * @property $car
 */
class CustomerMap extends ObjectMap
{
    public function getDocumentTypeAttribute($value)
    {
        return strtoupper($value);
    }
    public function setCityAttribute($value)
    {
        if($value == 'Moscú')
            $this->attributes['country'] = 'Rusia';
    }
}