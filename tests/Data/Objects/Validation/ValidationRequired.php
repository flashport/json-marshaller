<?php namespace Tests\Data\Objects\Validation;

use JsonMarshaller\Attributes\Validation\Required;

class ValidationRequired{

    #[Required]
    public string $required;
}