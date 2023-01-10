<?php

namespace Tests\Unit\Unmarshal;

use JsonMarshaller\Exceptions\MismatchingTypesException;
use JsonMarshaller\Exceptions\MissingAttributeException;
use JsonMarshaller\Exceptions\UnsupportedConversionException;
use JsonMarshaller\Exceptions\ValidationException;
use JsonMarshaller\Exceptions\ValueAssignmentException;
use ReflectionException;
use Tests\Data\Objects\PersonWithoutSetter;
use Tests\Data\Objects\PersonWithProtectedName;
use Tests\Unit\BaseTestCase;

class SetterTest extends BaseTestCase
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
    public function it_uses_setter_function(): void
    {
        $file = $this->getJsonFile("person.json");

        /** @var PersonWithProtectedName $person */
        $person = $this->JSON->unmarshal($file, PersonWithProtectedName::class);

        $this->assertEquals("John Doe Modified", $person->getName());
    }

    /**
     * @test
     * @return void
     * @throws MismatchingTypesException
     * @throws MissingAttributeException
     * @throws ReflectionException
     * @throws UnsupportedConversionException
     * @throws ValidationException
     */
    public function it_fails_to_set_protected_value() : void
    {
        $file = $this->getJsonFile("person.json");

        try {
            /** @var PersonWithoutSetter $person */
            $this->JSON->unmarshal($file, PersonWithoutSetter::class);
            $this->fail();
        }catch (ValueAssignmentException){}

    }
}