<?php namespace Tests\Data\Objects;

use JsonMarshaller\Attributes\JsonIgnore;

class PersonWithIgnoredProperty
{

    public string $name;

    public string $emailAddress;
    
    public Gender $gender;

    public Address $address;

    #[JsonIgnore]
    public string $age;
}