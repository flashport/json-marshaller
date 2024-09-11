<?php

namespace Tests\Unit\Unmarshal;

use JsonMarshaller\Exceptions\JsonMarshallerException;
use JsonMarshaller\Exceptions\MismatchingTypesException;
use JsonMarshaller\Exceptions\MissingAttributeException;
use JsonMarshaller\Exceptions\UnsupportedConversionException;
use JsonMarshaller\Exceptions\ValidationException;
use JsonMarshaller\Exceptions\ValueAssignmentException;
use ReflectionException;
use Tests\Data\Objects\ArrayOfObjectsWithBypass;
use Tests\Data\Objects\Person;
use Tests\Data\Objects\PersonWithBypassedAddress;
use Tests\Unit\BaseTestCase;

class BypassTest extends BaseTestCase
{
    
    
    /**
     * @test
     * @return void
     * @throws MismatchingTypesException
     * @throws MissingAttributeException
     * @throws ReflectionException
     * @throws UnsupportedConversionException
     * @throws ValidationException
     * @throws ValueAssignmentException
     * @throws JsonMarshallerException
     */
    public function it_bypasses_objects(): void
    {
        $file = $this->getJsonFile("person.json");

        /** @var PersonWithBypassedAddress $person */
        $person = $this->jsonMarshaller->unmarshal($file, PersonWithBypassedAddress::class);
        $this->assertTrue(property_exists($person, "address"));
        
        $this->assertEquals(
            json_encode([
                "street" => "Nice Street",
                "number" => 10,
                "zip" =>  12345,
                "city" => "New York"
            ]),
            json_encode($person->address)
        );
    }
    
    /**
     * @test
     * @return void
     * @throws JsonMarshallerException
     * @throws MismatchingTypesException
     * @throws MissingAttributeException
     * @throws ReflectionException
     * @throws UnsupportedConversionException
     * @throws ValidationException
     * @throws ValueAssignmentException
     */
    public function it_bypasses_arrays(): void
    {
        $file = $this->getJsonFile("array-of-objects.json");
        
        /** @var ArrayOfObjectsWithBypass $array */
        $array = $this->jsonMarshaller->unmarshal($file, ArrayOfObjectsWithBypass::class);
        
        $this->assertTrue(property_exists($array, "addresses"));
        $this->assertNotNull($array->addresses);
        $this->assertCount(3, $array->addresses);
        
        $this->assertEquals(
            json_encode([
                "street" => "Nice Street",
                "number" => 10,
                "zip" =>  12345,
                "city" => "New York"
            ]),
            json_encode($array->addresses[0])
        );
    }
}