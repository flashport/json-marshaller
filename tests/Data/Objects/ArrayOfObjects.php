<?php namespace Tests\Data\Objects;

use JsonMarshaller\Attributes\JsonPropertyType;

class ArrayOfObjects
{

    #[JsonPropertyType(Address::class)]
    public array $addresses;
}