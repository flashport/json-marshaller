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

class ScalarsTest extends BaseTestCase
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
    public function it_unmarshals_scalars(): void
    {
        $file = $this->getJsonFile("scalars.json");

        /** @var Scalars $scalars */
        $scalars = $this->JSON->unmarshal($file, Scalars::class);

        $this->assertEquals(10, $scalars->integer);
        $this->assertEquals(1.1, $scalars->float);
        $this->assertEquals(true, $scalars->boolean);
        $this->assertEquals("Hello World", $scalars->string);
    }
}