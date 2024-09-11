<?php namespace Tests\Data\Objects;

use JsonMarshaller\Attributes\JsonUnmarshalBypass;
use stdClass;

class PersonWithBypassedAddress
{

    public string $name;

    public string $emailAddress;
    
    public Gender $gender;

    #[JsonUnmarshalBypass]
    public stdClass $address;
}