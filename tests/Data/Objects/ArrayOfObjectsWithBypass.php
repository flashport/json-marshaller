<?php namespace Tests\Data\Objects;

use JsonMarshaller\Attributes\JsonUnmarshalBypass;

class ArrayOfObjectsWithBypass
{

    #[JsonUnmarshalBypass]
    public array $addresses;
}