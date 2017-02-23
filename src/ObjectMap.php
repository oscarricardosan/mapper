<?php

namespace Oscarsan\ObjectMap;

use Oscarsan\ObjectMap\Interfaces\ObjectMapInterface;

abstract class ObjectMap implements ObjectMapInterface
{
    public function __construct(array $attributes = [])
    {
        $this->setAttributesArray($attributes);
    }

    public function setAttributesArray(array $attributes = [])
    {
        foreach($attributes as $attribute => $value){
            if(property_exists($this ,$attribute)){
                $this->{$attribute} = $value;
            }
        }
    }

    public function getAttributes()
    {
        return get_object_vars($this);
    }

}