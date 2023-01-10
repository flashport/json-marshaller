<?php namespace JsonMarshaller\Attributes\Validation;

use Attribute;

#[Attribute]
class Equals implements ValidationAttribute {

    protected array $compareTo;

    /**
     * @param mixed $compareTo
     */
    public function __construct(mixed $compareTo)
    {

        $this->compareTo = is_array($compareTo) ? $compareTo : [$compareTo];
    }

    public function isValid(mixed &$value): bool
    {
        return in_array($value, $this->compareTo);
    }
}