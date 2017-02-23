<?php


namespace Oscarricardosan\ObjectMap;


class DocComment
{
    protected $doc = '';
    protected $properties = [];

    public function __construct($class = null)
    {
        if(!is_null($class))
            $this->loadDocFromClass($class);
    }

    public function loadDocFromClass($class)
    {
        $this->doc = (new \ReflectionClass($class))->getDocComment();
    }

    public function getProperties()
    {
        $this->extractPropertiesFromDocComments();
        return $this->properties;
    }

    protected function extractPropertiesFromDocComments()
    {
        $lines = explode("\n", $this->doc);
        foreach ($lines as $line){
            $property = $this->getPropertyFromLine($line);
            if(!is_null($property))
               $this->properties = array_merge($this->properties, $property);
        }
    }

    protected function getPropertyFromLine($string)
    {
        $property = null;
        if (strpos($string, '@property') !== false) {
           $property = [$this->getNameFromLine($string) => $this->getValueFromLine($string)];
        }
        return $property;

    }

    protected function getNameFromLine($string)
    {
        $parts = explode(' ', $string);
        foreach ($parts as $key => $part){
            $type = substr($part, 0, 1);
            if($type == '$')
                return str_replace('$', '', $parts[$key]);
        }
    }

    protected function getValueFromLine($string)
    {
        $parts = explode('"', $string);
        return isset($parts[1])?$parts[1]:null;
    }
}