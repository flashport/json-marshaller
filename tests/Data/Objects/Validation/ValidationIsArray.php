<?php namespace Tests\Data\Objects\Validation;

use JsonMarshaller\Attributes\JsonPropertyType;
use JsonMarshaller\Attributes\Validation\IsArray;
use JsonMarshaller\Resources\ScalarTypes;

class ValidationIsArray{

    #[IsArray]
    #[JsonPropertyType(ScalarTypes::STRING)]
    public array $isArray;
}