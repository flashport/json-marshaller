<?php

namespace Tests\Unit\Unmarshal;

use JsonMarshaller\Exceptions\MismatchingTypesException;
use JsonMarshaller\Exceptions\MissingAttributeException;
use JsonMarshaller\Exceptions\UnsupportedConversionException;
use JsonMarshaller\Exceptions\ValidationException;
use JsonMarshaller\Exceptions\ValueAssignmentException;
use JsonMarshaller\JsonMarshaller;
use JsonMarshaller\JsonMarshallerFlags;
use ReflectionException;
use Tests\Data\Objects\PersonWithoutSetter;
use Tests\Unit\BaseTestCase;

class NullOnErrorFlagTest extends BaseTestCase
{

    /**
     * @test
     * @return void
     * @throws MismatchingTypesException
     * @throws MissingAttributeException
     * @throws ReflectionException
     * @throws UnsupportedConversionException
     * @throws ValidationException|ValueAssignmentException
     */
    public function it_returns_null_on_error(): void
    {

        $this->jsonMarshaller = new JsonMarshaller(JsonMarshallerFlags::RETURN_NULL_ON_ERROR);

        $file = $this->getJsonFile("person.json");

        $result = $this->jsonMarshaller->unmarshal($file, PersonWithoutSetter::class);

        $this->assertEquals("", $result);
    }
}