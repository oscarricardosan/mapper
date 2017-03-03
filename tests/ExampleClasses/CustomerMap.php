<?php

namespace Oscarricardosan\Mapper\Tests\ExamplesClasses;

use Oscarricardosan\Mapper\Mapper;

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
class CustomerMap extends Mapper
{
    protected $alias = [
        0 => 'name',
        1 => 'car',
        2 => 'document_type'
    ];
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