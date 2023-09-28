<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace Tests\Data\Objects;

use JsonMarshaller\Attributes\JsonPropertyType;

class PersonWithTypedAttribute
{

    public $name;

    public $emailAddress;

    #[JsonPropertyType(Address::class)]
    public $address;
    
    public $gender;
}