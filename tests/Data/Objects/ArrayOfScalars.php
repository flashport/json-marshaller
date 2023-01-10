<?php namespace Tests\Data\Objects;

use JsonMarshaller\Attributes\JsonPropertyType;
use JsonMarshaller\Resources\ScalarTypes;

class ArrayOfScalars{

    #[JsonPropertyType(ScalarTypes::INTEGER)]
    public array $integers;

    #[JsonPropertyType(ScalarTypes::FLOAT)]
    public array $floats;

    #[JsonPropertyType(ScalarTypes::BOOLEAN)]
    public array $booleans;

    #[JsonPropertyType(ScalarTypes::STRING)]
    public array $strings;

}