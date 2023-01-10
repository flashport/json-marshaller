<?php namespace Tests\Data\Objects\Validation;

use JsonMarshaller\Attributes\Validation\Equals;

class ValidationEquals{

    #[Equals("foo")]
    public string $equals;
}