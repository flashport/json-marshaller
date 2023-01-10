<?php namespace Tests\Data\Objects;

use JsonMarshaller\Attributes\JsonProperty;

class PersonWithNamedProperty{

    public string $name;

    #[JsonProperty("emailAddress")]
    public string $email;

    public Address $address;
}