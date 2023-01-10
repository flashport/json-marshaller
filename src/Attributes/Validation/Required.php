<?php namespace JsonMarshaller\Attributes\Validation;

use Attribute;

#[Attribute]
class Required implements ValidationAttribute {

    public function isValid(mixed &$value): bool
    {
        return ! empty($value);
    }
}