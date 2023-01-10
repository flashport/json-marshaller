<?php

namespace Tests\Unit\Marshal;

use Exception;
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
     */
    public function it_marshals_scalars(): void
    {
        $scalars = new Scalars();
        $scalars->integer = 10;
        $scalars->float = 1.1;
        $scalars->boolean = true;
        $scalars->string = "Hello World";

        $json = $this->JSON->marshal($scalars);

        $this->assertEquals("{\"integer\":10,\"float\":1.1,\"boolean\":true,\"string\":\"Hello World\"}", $json);
    }
}