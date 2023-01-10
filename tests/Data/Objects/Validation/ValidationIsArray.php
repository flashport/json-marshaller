<?php namespace Tests\Data\Objects\Validation;

use JsonMarshaller\Attributes\JsonPropertyType;
use JsonMarshaller\Attributes\Validation\JsonValidateIsArray;
use JsonMarshaller\Resources\ScalarTypes;

class ValidationIsArray
{

    #[JsonValidateIsArray]
    #[JsonPropertyType(ScalarTypes::STRING)]
    public array $isArray;
}