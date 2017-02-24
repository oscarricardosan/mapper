<?php

namespace Oscarricardosan\Mapper;

use Oscarricardosan\Mapper\Interfaces\MapperInterface;

abstract class Mapper implements MapperInterface
{
    protected $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->setPropertiesFromDocComments();
        $this->setAttributesFromArray($attributes);
    }

    protected function setPropertiesFromDocComments()
    {
        $this->attributes = (new DocComment($this))->getProperties();
    }

    public function setAttributesFromArray(array $attributes = [])
    {
        foreach($attributes as $attribute => $value){
            if($this->attributeExists($attribute)){
                $this->{$attribute} = $value;
            }
        }
    }

    public function getAttributes()
    {
        $attributes = [];
        foreach ($this->attributes as $attribute => $value){
            $attributes[$attribute] = $this->{$attribute};
        }
        return $attributes;
    }

    public function __get($name)
    {
        return $this->getAttributeValue($name);
    }

    protected function getAttributeValue($attribute)
    {
        if($this->hasGetMutator($attribute))
            return $this->getValueFromMutator($attribute);
        else
            return $this->getValueFromAttributes($attribute);
    }

    protected function hasGetMutator($attribute)
    {
        return method_exists($this, $this->nameGetMutator($attribute));
    }

    protected function getValueFromMutator($attribute)
    {
        $method = $this->nameGetMutator($attribute);
        $value = $this->attributes[$attribute];
        return $this->{$method}($value);
    }

    protected function nameGetMutator($attribute)
    {
        return 'get'.Str::convertToMutatorName($attribute).'Attribute';
    }

    protected function getValueFromAttributes($attribute)
    {
        if($this->attributeExists($attribute))
            return $this->attributes[$attribute];
    }

    public function __set($name, $value)
    {
        return $this->setAttributeValue($name, $value);
    }

    protected function setAttributeValue($attribute, $value)
    {
        if($this->hasSetMutator($attribute))
            return $this->setValueFromMutator($attribute, $value);
        else
            return $this->setValueToAttributes($attribute, $value);
    }

    protected function hasSetMutator($attribute)
    {
        return method_exists($this, $this->nameSetMutator($attribute));
    }

    protected function setValueFromMutator($attribute, $value)
    {
        $method = $this->nameSetMutator($attribute);
        $this->{$method}($value);
    }

    protected function nameSetMutator($attribute)
    {
        return 'set'.Str::convertToMutatorName($attribute).'Attribute';
    }

    protected function setValueToAttributes($attribute, $value)
    {
        if($this->attributeExists($attribute))
            $this->attributes[$attribute] = $value;
    }

    protected function attributeExists($attribute)
    {
        return array_key_exists($attribute, $this->attributes);
    }
}