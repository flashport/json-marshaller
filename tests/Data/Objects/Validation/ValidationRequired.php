<?php namespace Tests\Data\Objects\Validation;

use JsonMarshaller\Attributes\Validation\JsonValidateRequired;

class ValidationRequired
{

    #[JsonValidateRequired]
    public string $required;
}