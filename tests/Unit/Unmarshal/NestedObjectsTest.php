<?php

namespace Tests\Unit\Unmarshal;

use JsonMarshaller\Exceptions\MismatchingTypesException;
use JsonMarshaller\Exceptions\MissingAttributeException;
use JsonMarshaller\Exceptions\UnsupportedConversionException;
use JsonMarshaller\Exceptions\ValidationException;
use JsonMarshaller\Exceptions\ValueAssignmentException;
use ReflectionException;
use Tests\Data\Objects\Address;
use Tests\Data\Objects\Person;
use Tests\Data\Objects\PersonWithNamedProperty;
use Tests\Data\Objects\PersonWithoutTypedProperties;
use Tests\Data\Objects\PersonWithTypedAttribute;
use Tests\Data\Objects\Scalars;
use Tests\Unit\BaseTestCase;

class NestedObjectsTest extends BaseTestCase
{
    /**
     * @test
     * @return void
     * @throws MismatchingTypesException
     * @throws ReflectionException
     * @throws UnsupportedConversionException
     * @throws ValidationException
     * @throws ValueAssignmentException
     */
    public function it_fails_to_infer_nested_object_type() : void
    {
        $file = $this->getJsonFile("person.json");

        try {
            /** @var PersonWithoutTypedProperties $person */
            $this->JSON->unmarshal($file, PersonWithoutTypedProperties::class);
            $this->fail();
        }catch (MissingAttributeException){}
    }

    /**
     * @test
     * @return void
     * @throws UnsupportedConversionException
     * @throws ValueAssignmentException
     * @throws MissingAttributeException
     * @throws ValidationException
     * @throws MismatchingTypesException
     * @throws ReflectionException
     */
    public function it_gets_nested_object_type_from_attribute() : void
    {
        $file = $this->getJsonFile("person.json");

        /** @var PersonWithTypedAttribute $person */
        $person = $this->JSON->unmarshal($file, PersonWithTypedAttribute::class);

        $this->assertEquals(Address::class, get_class($person->address));
    }

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
    public function it_unmarshal_nested_objects(): void
    {
        $file = $this->getJsonFile("person.json");

        /** @var Person $person */
        $person = $this->JSON->unmarshal($file, Person::class);

        $this->assertEquals(Address::class, get_class($person->address));
        $this->assertNotEmpty($person->address->street);
        $this->assertNotEmpty($person->address->number);
        $this->assertNotEmpty($person->address->zip);
        $this->assertNotEmpty($person->address->city);
    }
}