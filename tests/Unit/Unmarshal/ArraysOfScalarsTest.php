<?php

namespace Tests\Unit\Unmarshal;

use JsonMarshaller\Exceptions\MismatchingTypesException;
use JsonMarshaller\Exceptions\MissingAttributeException;
use JsonMarshaller\Exceptions\UnsupportedConversionException;
use JsonMarshaller\Exceptions\ValidationException;
use JsonMarshaller\Exceptions\ValueAssignmentException;
use ReflectionException;
use Tests\Data\Objects\ArrayOfScalars;
use Tests\Unit\BaseTestCase;

class ArraysOfScalarsTest extends BaseTestCase
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
    public function it_unmarshals_arrays_of_scalars(): void
    {
        $file = $this->getJsonFile("array-of-scalars.json");

        /** @var ArrayOfScalars $arrayOfScalars */
        $arrayOfScalars = $this->jsonMarshaller->unmarshal($file, ArrayOfScalars::class);

        $this->assertEquals([10, 20, 30, 40, 50], $arrayOfScalars->integers);
        $this->assertEquals([1.1, 2.2, 3.3, 4.4, 5.5], $arrayOfScalars->floats);
        $this->assertEquals([true, false, true, false, true], $arrayOfScalars->booleans);
        $this->assertEquals(["foo", "bar", "baz", "qux", "qua"], $arrayOfScalars->strings);
    }
}