<?php namespace JsonMarshaller\Traits;

use ReflectionProperty;

trait GetsReflectedPropertyAttributes{

    protected function getReflectedPropertyAttribute(ReflectionProperty $reflectionProperty, string $attributeClass) : mixed
    {
        $attributes = $reflectionProperty->getAttributes($attributeClass);
        return isset($attributes[0]) ? $attributes[0]->newInstance() : null;
    }
}