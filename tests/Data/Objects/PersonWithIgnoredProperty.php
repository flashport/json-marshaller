<?php namespace Tests\Data\Objects;

use JsonMarshaller\Attributes\JsonIgnore;

class PersonWithIgnoredProperty
{

    public string $name;

    public string $emailAddress;

    public Address $address;

    #[JsonIgnore]
    public string $gender;
}