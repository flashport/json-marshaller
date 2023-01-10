<?php

namespace Tests\Unit\Unmarshal;

use JsonMarshaller\Exceptions\MismatchingTypesException;
use JsonMarshaller\Exceptions\MissingAttributeException;
use JsonMarshaller\Exceptions\UnsupportedConversionException;
use JsonMarshaller\Exceptions\ValidationException;
use JsonMarshaller\Exceptions\ValueAssignmentException;
use ReflectionException;
use Tests\Data\Objects\Validation\ValidationEquals;
use Tests\Data\Objects\Validation\ValidationIsArray;
use Tests\Data\Objects\Validation\ValidationRequired;
use Tests\Unit\BaseTestCase;

class ValidationTest extends BaseTestCase
{

    protected string $validationFailFile;

    protected string $validationSuccessFile;

    public function setUp() : void
    {
        parent::setUp();

        $this->validationFailFile       = $this->getJsonFile("validation-fail.json");
        $this->validationSuccessFile    = $this->getJsonFile("validation-success.json");
    }

    /**
     * @test
     * @return void
     * @throws MismatchingTypesException
     * @throws MissingAttributeException
     * @throws UnsupportedConversionException
     * @throws ValueAssignmentException
     * @throws ReflectionException
     * @throws ValidationException
     */
    public function it_validates_equals() : void
    {
        try {
            $this->JSON->unmarshal($this->validationFailFile, ValidationEquals::class);
            // Reaching here, it never failed to validate
            $this->fail();
        }catch (ValidationException){}

        /** @var ValidationEquals $validationSuccess */
        $validationSuccess = $this->JSON->unmarshal($this->validationSuccessFile, ValidationEquals::class);

        $this->assertEquals("foo", $validationSuccess->equals);
    }

    /**
     * @test
     * @return void
     * @throws MismatchingTypesException
     * @throws MissingAttributeException
     * @throws UnsupportedConversionException
     * @throws ValueAssignmentException
     * @throws ReflectionException
     * @throws ValidationException
     */
    public function it_validates_is_array() : void
    {
        try {
            $this->JSON->unmarshal($this->validationFailFile, ValidationIsArray::class);
            // Reaching here, it never failed to validate
            $this->fail();
        }catch (ValidationException){}

        /** @var ValidationIsArray $validationSuccess */
        $validationSuccess = $this->JSON->unmarshal($this->validationSuccessFile, ValidationIsArray::class);

        $this->assertEquals(["foo", "bar"], $validationSuccess->isArray);
    }

    /**
     * @test
     * @return void
     * @throws MismatchingTypesException
     * @throws MissingAttributeException
     * @throws UnsupportedConversionException
     * @throws ValueAssignmentException
     * @throws ReflectionException
     * @throws ValidationException
     */
    public function it_validates_is_required() : void
    {
        try {
            $this->JSON->unmarshal($this->validationFailFile, ValidationRequired::class);
            // Reaching here, it never failed to validate
            $this->fail();
        }catch (ValidationException){}

        /** @var ValidationRequired $validationSuccess */
        $validationSuccess = $this->JSON->unmarshal($this->validationSuccessFile, ValidationRequired::class);

        $this->assertEquals("bar", $validationSuccess->required);
    }
}