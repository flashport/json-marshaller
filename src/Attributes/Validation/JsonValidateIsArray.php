<?php namespace JsonMarshaller\Attributes\Validation;

use Attribute;

#[Attribute]
class JsonValidateIsArray implements ValidationAttribute
{

    public function isValid(mixed &$value): bool
    {
        return is_array($value);
    }
}