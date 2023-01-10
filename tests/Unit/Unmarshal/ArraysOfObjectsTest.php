<?php

namespace Tests\Unit\Unmarshal;

use JsonMarshaller\Exceptions\MismatchingTypesException;
use JsonMarshaller\Exceptions\MissingAttributeException;
use JsonMarshaller\Exceptions\UnsupportedConversionException;
use JsonMarshaller\Exceptions\ValidationException;
use JsonMarshaller\Exceptions\ValueAssignmentException;
use ReflectionException;
use Tests\Data\Objects\Address;
use Tests\Data\Objects\ArrayOfObjects;
use Tests\Unit\BaseTestCase;

class ArraysOfObjectsTest extends BaseTestCase
{

    /**
     * @test
     * @return void
     * @throws MismatchingTypesException
     * @throws MissingAttributeException
     * @throws UnsupportedConversionException
     * @throws ValidationException
     * @throws ValueAssignmentException
     * @throws ReflectionException
     */
    public function it_unmarshals_arrays_of_objects(): void
    {
        $file = $this->getJsonFile("array-of-objects.json");

        /** @var ArrayOfObjects $arrayOfObjects */
        $arrayOfObjects = $this->JSON->unmarshal($file, ArrayOfObjects::class);

        $this->assertCount(3, $arrayOfObjects->addresses);

        /** @var Address $address */
        foreach($arrayOfObjects->addresses as $address){
            $this->assertEquals(Address::class, get_class($address));

            $this->assertNotEmpty($address->street);
            $this->assertNotEmpty($address->number);
            $this->assertNotEmpty($address->zip);
            $this->assertNotEmpty($address->city);
        }

    }
}