<?php

namespace Tests\Unit\Unmarshal;

use JsonMarshaller\Exceptions\MismatchingTypesException;
use JsonMarshaller\Exceptions\MissingAttributeException;
use JsonMarshaller\Exceptions\UnsupportedConversionException;
use JsonMarshaller\Exceptions\ValidationException;
use JsonMarshaller\Exceptions\ValueAssignmentException;
use ReflectionException;
use Tests\Data\Objects\PersonWithNamedProperty;
use Tests\Unit\BaseTestCase;

class NamedPropertyTest extends BaseTestCase
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
    public function it_uses_named_property(): void
    {
        $file = $this->getJsonFile("person.json");

        /** @var PersonWithNamedProperty $person */
        $person = $this->JSON->unmarshal($file, PersonWithNamedProperty::class);

        // The property inside the json file is "emailAddress"
        $this->assertEquals("john.doe@email.com", $person->email);
    }
}