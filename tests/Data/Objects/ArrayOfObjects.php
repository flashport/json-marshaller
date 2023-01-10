<?php namespace Tests\Data\Objects;

use JsonMarshaller\Attributes\JsonPropertyType;
use JsonMarshaller\Resources\ScalarTypes;

class ArrayOfObjects
{

    #[JsonPropertyType(Address::class)]
    public array $addresses;
}