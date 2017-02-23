<?php

namespace Oscarsan\ObjectMap\Tests;


use Oscarsan\ObjectMap\Tests\ExamplesClasses\BasicExample;

class GeneralTest extends BaseTest
{
    protected $sample = [
        'name' => 'oscar',
        'document_type' => 'cc',
        'document_number' => '000255',
        'city' => 'Bogota',
        'state' => 'Bogota',
        'country' => 'Colombia',
        'car' => 'toyota',
    ];

    /**
     * @test
     */
    public function is_constructWithArray_Working()
    {
        $objectMap = new BasicExample($this->sample);
        foreach ($this->sample as $attribute => $value){
            $this->assertEquals($value, $objectMap->{$attribute});
        }
        $this->assertEquals('PHP Company', $objectMap->company);
    }

    /**
     * @test
     */
    public function is_getAttributtes_Working()
    {
        $objectMap = new BasicExample($this->sample);
        $attributes = $objectMap->getAttributes();

        foreach ($attributes as $attribute => $value){
            $this->assertEquals($value, $attributes[$attribute]);
        }
        $this->assertEquals('PHP Company', $attributes['company']);

        $this->assertEquals(8, count($objectMap->getAttributes()));
    }


    /*public function is_setter_Working()
    {
        $objectMap = new BasicExample();
        $objectMap->company = 'Toyota';
        //$this->assertEquals('TOYOTA', $objectMap->company);
    }*/
}