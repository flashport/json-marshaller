<?php

namespace Tests\Unit\Marshal;

use JsonMarshaller\Exceptions\JsonMarshallerException;
use JsonMarshaller\Exceptions\ValidationException;
use ReflectionException;
use Tests\Data\Objects\Scalars;
use Tests\Unit\BaseTestCase;

class ScalarsTest extends BaseTestCase
{

    /**
     * @test
     * @return void
     * @throws ReflectionException
     * @throws ValidationException
     * @throws JsonMarshallerException
     */
    public function it_marshals_scalars(): void
    {
        $scalars = new Scalars();
        $scalars->integer = 10;
        $scalars->float = 1.1;
        $scalars->boolean = true;
        $scalars->string = "Hello World";

        $json = $this->jsonMarshaller->marshal($scalars);

        $file = json_encode(json_decode($this->getJsonFile("scalars.json")));

        $this->assertEquals($file, $json);
    }
}