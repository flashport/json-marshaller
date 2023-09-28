<?php namespace JsonMarshaller\Processors;

use Closure;
use JsonMarshaller\Attributes\JsonIgnore;
use JsonMarshaller\Attributes\Validation\ValidationAttribute;
use JsonMarshaller\Exceptions\InvalidFlagException;
use JsonMarshaller\Exceptions\ValidationException;
use JsonMarshaller\JsonMarshallerFlags;
use JsonMarshaller\Processors\Traits\UsesFlags;
use ReflectionProperty;

abstract class BaseProcessor
{

    use UsesFlags;

    /**
     * @param string ...$flags
     * @throws InvalidFlagException
     */
    public function __construct(string ...$flags)
    {
        $this->setFlags(...$flags);
    }

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
     * @param object $object
     * @param ReflectionProperty $reflectionProperty
     * @return mixed
     */
    protected function getPrivatePropertyValue(object $object, ReflectionProperty $reflectionProperty) : mixed
    {
        $getter = function(object $object, ReflectionProperty $reflectionProperty){
            
            if(enum_exists($reflectionProperty->getType()->getName())) {
                return $object->{$reflectionProperty->getName()}->getValue();
            }
            
            return $object->{$reflectionProperty->getName()};
        };

        $getter = Closure::bind($getter, null, $object);

        return $getter($object, $reflectionProperty);
    }

    /**
     * @param ReflectionProperty $reflectionProperty
     * @return bool
     */
    protected function shouldIgnoreProperty(ReflectionProperty $reflectionProperty): bool
    {
        return !!$this->getReflectedPropertyAttribute($reflectionProperty, JsonIgnore::class);
    }

    /**
     * @return bool
     */
    protected function shouldReturnNullOnErrors() : bool
    {
        return $this->hasFlag(JsonMarshallerFlags::RETURN_NULL_ON_ERROR);
    }

    /**
     * @return bool
     */
    protected function shouldAccessPrivateProperties() : bool
    {
        return $this->hasFlag(JsonMarshallerFlags::ACCESS_PRIVATE_PROPERTIES);
    }
}
