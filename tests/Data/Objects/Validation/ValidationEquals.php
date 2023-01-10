<?php namespace Tests\Data\Objects\Validation;

use JsonMarshaller\Attributes\Validation\JsonValidateEquals;

class ValidationEquals
{

    #[JsonValidateEquals("foo")]
    public string $equals;
}