<?php namespace JsonMarshaller\Processors;

use JsonMarshaller\Attributes\JsonIgnore;
use JsonMarshaller\Attributes\Validation\ValidationAttribute;
use JsonMarshaller\Exceptions\ValidationException;
use ReflectionProperty;

abstract class BaseProcessor
{
    /**
     * @param ReflectionProperty $reflectionProperty
     * @param string $attributeClass
     * @return mixed
     */
    protected function getReflectedPropertyAttribute(ReflectionProperty $reflectionProperty, string $attributeClass): mixed
    {
        $attributes = $reflectionProperty->getAttributes($attributeClass);
        return isset($attributes[0]) ? $attributes[0]->newInstance() : null;
    }

    /**
     * @param ReflectionProperty $reflectionProperty
     * @param mixed $value
     * @return void
     * @throws ValidationException
     */
    protected function validateReflectedProperty(ReflectionProperty $reflectionProperty, mixed &$value): void
    {
        $attributes = $reflectionProperty->getAttributes();

        if (!count($attributes)) {
            return;
        }

        foreach ($attributes as $attribute) {

            $implements = class_implements($attribute->getName());
            if (!isset($implements[ValidationAttribute::class])) {
                continue;
            }

            /** @var ValidationAttribute $validationAttribute */
            $validationAttribute = $attribute->newInstance();

            if (!$validationAttribute->isValid($value)) {
                throw new ValidationException("Error while validating property {$reflectionProperty->getName()}. Fails at {$attribute->getName()}");
            }

        }
    }

    /**
     * @param ReflectionProperty $reflectionProperty
     * @return bool
     */
    protected function shouldIgnoreProperty(ReflectionProperty $reflectionProperty): bool
    {
        return !!$this->getReflectedPropertyAttribute($reflectionProperty, JsonIgnore::class);
    }
}
