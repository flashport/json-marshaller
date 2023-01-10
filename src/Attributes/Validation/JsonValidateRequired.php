<?php namespace JsonMarshaller\Attributes\Validation;

use Attribute;

#[Attribute]
class JsonValidateRequired implements ValidationAttribute
{

    public function isValid(mixed &$value): bool
    {
        return !empty($value);
    }
}