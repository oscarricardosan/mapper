<?php


namespace Oscarricardosan\Mapper;


class Str
{
    public static function convertToMutatorName($value)
    {
        $result = ucwords(str_replace('_', ' ', $value));
        return str_replace(' ', '', $result);
    }
}