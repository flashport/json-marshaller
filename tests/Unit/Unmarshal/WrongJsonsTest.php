<?php

namespace Tests\Unit\Unmarshal;

use JsonMarshaller\Exceptions\MismatchingTypesException;
use JsonMarshaller\Exceptions\MissingAttributeException;
use JsonMarshaller\Exceptions\UnsupportedConversionException;
use JsonMarshaller\Exceptions\ValidationException;
use JsonMarshaller\Exceptions\ValueAssignmentException;
use ReflectionException;
use Tests\Data\Objects\Scalars;
use Tests\Unit\BaseTestCase;

class WrongJsonsTest extends BaseTestCase
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
    public function it_doesnt_break_on_empty(): void
    {
        $file = $this->getJsonFile("empty.json");

        /** @var Scalars $scalars */
        $scalars = $this->jsonMarshaller->unmarshal($file, Scalars::class);

        $this->assertNull($scalars);
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
    public function it_doesnt_break_on_invalid_json(): void
    {
        $file = $this->getJsonFile("invalid.json");

        /** @var Scalars $scalars */
        $scalars = $this->jsonMarshaller->unmarshal($file, Scalars::class);

        $this->assertNull($scalars);
    }

}