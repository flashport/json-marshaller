<?php

namespace Tests\Unit\Marshal;

use JsonMarshaller\Exceptions\ValidationException;
use ReflectionException;
use Tests\Data\Objects\ArrayOfScalars;
use Tests\Data\Objects\Scalars;
use Tests\Unit\BaseTestCase;

class ArrayOfScalarsTest extends BaseTestCase
{

    /**
     * @test
     * @return void
     * @throws ValidationException
     * @throws ReflectionException
     */
    public function it_marshals_array_of_scalars(): void
    {
        $arrayOfScalars = new ArrayOfScalars();
        $arrayOfScalars->integers = [10, 20, 30, 40, 50];
        $arrayOfScalars->floats = [1.1, 2.2, 3.3, 4.4, 5.5];
        $arrayOfScalars->booleans = [true, false, true, false, true];
        $arrayOfScalars->strings = ["foo", "bar", "baz", "qux", "qua"];

        $json = $this->jsonMarshaller->marshal($arrayOfScalars);

        $file = json_encode(json_decode($this->getJsonFile("array-of-scalars.json")));

        $this->assertEquals($file, $json);
    }
}