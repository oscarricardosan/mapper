<?php

namespace Oscarricardosan\Mapper\Tests;



use Oscarricardosan\Mapper\Tests\ExamplesClasses\CustomerMap;

class GeneralTest extends BaseTest
{
    protected $sample = [
        'name' => 'oscar',
        'document_type' => 'cc',
        'document_number' => '000255',
        'country' => 'Colombia',
        'city' => 'Moscú',
        'state' => 'Bogota',
        'car' => 'toyota',
    ];

    /**
     * @test
     */
    public function is_constructWithArray_Working()
    {
        $customerMap = new CustomerMap($this->sample);
        $this->assertEquals('PHP Company', $customerMap->company);
    }

    /**
     * @test
     */
    public function is_getAttributtes_Working()
    {
        $customerMap = new CustomerMap($this->sample);
        $attributes = $customerMap->getAttributes();

        $this->assertEquals('PHP Company', $attributes['company']);

        $this->assertEquals(8, count($customerMap->getAttributes()));
    }

    /**
     * @test
     */
    public function is_get_Working()
    {
        $customerMap = new CustomerMap();
        $customerMap->car = 'mazda';
        $this->assertEquals('mazda', $customerMap->car);
    }

    /**
     * @test
     */
    public function is_magicGet_Working()
    {
        $customerMap = new CustomerMap($this->sample);
        $this->assertEquals('CC', $customerMap->document_type);
        $customerMap->document_type = 'ti';
        $this->assertEquals('TI', $customerMap->document_type);
    }

    /**
     * @test
     */
    public function is_magicGetFromConstruct_Working()
    {
        $customerMap = new CustomerMap($this->sample);
        $this->assertEquals('CC', $customerMap->document_type);
    }

    /**
     * @test
     */
    public function is_set_Working()
    {
        $customerMap = new CustomerMap($this->sample);
        $customerMap->company = 'C++ Company';
        $this->assertEquals('C++ Company', $customerMap->company);
    }

    /**
     * @test
     */
    public function is_magicSet_Working()
    {
        $customerMap = new CustomerMap();
        $customerMap->city = 'Moscú';
        $this->assertEquals('Rusia', $customerMap->country);
    }

    /**
     * @test
     */
    public function is_magicSetFromConstruct_Working()
    {
        $customerMap = new CustomerMap(['city' => 'Moscú']);
        $this->assertEquals('Rusia', $customerMap->country);

        $customerMap = new CustomerMap(['city' => 'Bogota']);
        $this->assertEquals(null, $customerMap->country);
    }
}