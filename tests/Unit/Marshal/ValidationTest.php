<?php

namespace Tests\Unit\Marshal;

use JsonMarshaller\Exceptions\JsonMarshallerException;
use JsonMarshaller\Exceptions\ValidationException;
use ReflectionException;
use Tests\Data\Objects\Validation\ValidationEquals;
use Tests\Data\Objects\Validation\ValidationIsArray;
use Tests\Data\Objects\Validation\ValidationRequired;
use Tests\Unit\BaseTestCase;

class ValidationTest extends BaseTestCase
{

    /**
     * @test
     * @return void
     * @throws ReflectionException
     * @throws ValidationException
     * @throws JsonMarshallerException
     */
    public function it_validates_equals(): void
    {
        $validationEquals = new ValidationEquals();
        $validationEquals->equals = "bar";

        $this->expectException(ValidationException::class);
        $this->jsonMarshaller->marshal($validationEquals);
    }


    /**
     * @test
     * @return void
     * @throws JsonMarshallerException
     * @throws ReflectionException
     * @throws ValidationException
     */
    public function it_validates_is_array(): void
    {
        $validationIsArray = new ValidationIsArray();
        $this->expectException(ValidationException::class);
        $this->jsonMarshaller->marshal($validationIsArray);
    }

    /**
     * @test
     * @return void
     * @throws JsonMarshallerException
     * @throws ReflectionException
     * @throws ValidationException
     */
    public function it_validates_required(): void
    {
        $validationRequired = new ValidationRequired();
        $this->expectException(ValidationException::class);
        $this->jsonMarshaller->marshal($validationRequired);
    }
}