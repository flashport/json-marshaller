<?php

namespace Tests\Unit\Marshal;

use JsonMarshaller\Exceptions\ValidationException;
use ReflectionException;
use Tests\Data\Objects\Address;
use Tests\Data\Objects\ArrayOfObjects;
use Tests\Data\Objects\ArrayOfScalars;
use Tests\Data\Objects\Scalars;
use Tests\Unit\BaseTestCase;

class ArrayOfObjectsTest extends BaseTestCase
{

    /**
     * @test
     * @return void
     * @throws ValidationException
     * @throws ReflectionException
     */
    public function it_marshals_array_of_objects(): void
    {
        $arrayOfObjects = new ArrayOfObjects();

        $address = new Address();

        $address->street = "Nice Street";
        $address->number = 10;
        $address->zip =  12345;
        $address->city = "New York";
        $arrayOfObjects->addresses[] = $address;

        $address = new Address();
        $address->street = "Another Nice Street";
        $address->number = 20;
        $address->zip =  54321;
        $address->city = "Las Vegas";
        $arrayOfObjects->addresses[] = $address;

        $address = new Address();
        $address->street = "Nice Avenue";
        $address->number = 52;
        $address->zip =  132465;
        $address->city = "San Francisco";
        $arrayOfObjects->addresses[] = $address;


        $json = $this->jsonMarshaller->marshal($arrayOfObjects);

        $file = json_encode(json_decode($this->getJsonFile("array-of-objects.json")));

        $this->assertEquals($file, $json);
    }
}