<?php namespace JsonMarshaller\Attributes\Validation;

use Attribute;

#[Attribute]
class IsArray implements ValidationAttribute {

    public function isValid(mixed &$value): bool
    {
        return is_array($value);
    }
}