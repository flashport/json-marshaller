<?php namespace JsonMarshaller\Processors;

use JsonMarshaller\Attributes\JsonProperty;
use JsonMarshaller\Attributes\JsonPropertyType;
use JsonMarshaller\Exceptions\MismatchingTypesException;
use JsonMarshaller\Exceptions\MissingAttributeException;
use JsonMarshaller\Exceptions\UnsupportedConversionException;
use JsonMarshaller\Exceptions\ValidationException;
use JsonMarshaller\Exceptions\ValueAssignmentException;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use stdClass;

class Unmarshaller extends BaseProcessor
{

    /**
     * @param string $json
     * @param string $targetClass
     * @return object|array|null
     * @throws MismatchingTypesException
     * @throws MissingAttributeException
     * @throws ReflectionException
     * @throws UnsupportedConversionException
     * @throws ValidationException
     * @throws ValueAssignmentException
     */
    public function unmarshal(string $json, string $targetClass): object|array|null
    {
        // Initial decoding
        $raw = json_decode($json);

        $reflectionClass = new ReflectionClass($targetClass);

        // Single item handling
        if (is_object($raw)) {
            return $this->handleUnmarshal($raw, $reflectionClass);

        // Array handling
        }else if(is_array($raw)) {

            $ret = [];
            foreach ($raw as $item) {
                $ret[] = $this->handleUnmarshal($item, $reflectionClass);
            }
            return $ret;
        }

        return null;
    }

    /**
     * @param stdClass $raw
     * @param ReflectionClass $reflectionClass
     * @return object
     * @throws MismatchingTypesException
     * @throws MissingAttributeException
     * @throws ReflectionException
     * @throws ValidationException
     * @throws ValueAssignmentException
     * @throws UnsupportedConversionException
     */
    protected function handleUnmarshal(stdClass $raw, ReflectionClass $reflectionClass): object
    {
        $ret = $reflectionClass->newInstanceWithoutConstructor();
        $properties = $reflectionClass->getProperties();

        foreach ($properties as $reflectionProperty) {

            if($this->shouldIgnoreProperty($reflectionProperty)){
                continue;
            }

            $value = $this->getPropertyValueFromRawObject($raw, $reflectionProperty);

            $this->validateReflectedProperty($reflectionProperty, $value);

            $this->handleValueAssignment($reflectionProperty, $value, $ret);
        }

        return $ret;
    }

    /**
     * @param stdClass $raw
     * @param ReflectionProperty $reflectionProperty
     * @return mixed
     */
    protected function getPropertyValueFromRawObject(stdClass $raw, ReflectionProperty $reflectionProperty): mixed
    {
        /** @var JsonProperty|null $jsonProperty */
        $jsonProperty = $this->getReflectedPropertyAttribute($reflectionProperty, JsonProperty::class);

        if (!$jsonProperty) {
            return $raw->{$reflectionProperty->getName()} ?? null;
        }

        // If there is a JsonProperty attribute in the class, then we have to use its name instead of the class property original name
        return $raw->{$jsonProperty->getName()};
    }

    /**
     * @param ReflectionProperty $reflectionProperty
     * @param mixed $rawValue
     * @param object $ret
     * @return void
     * @throws MismatchingTypesException
     * @throws MissingAttributeException
     * @throws ReflectionException
     * @throws UnsupportedConversionException
     * @throws ValidationException
     * @throws ValueAssignmentException
     */
    protected function handleValueAssignment(ReflectionProperty $reflectionProperty, mixed &$rawValue, object $ret): void
    {
        if (is_scalar($rawValue)) {
            $this->setValueOnProperty($reflectionProperty, $rawValue, $ret);
        } else if (is_array($rawValue)) {
            $this->setArrayOnProperty($reflectionProperty, $rawValue, $ret);
        } else if (is_object($rawValue)) {
            $this->setObjectOnProperty($reflectionProperty, $rawValue, $ret);
        }

    }

    /**
     * @param ReflectionProperty $reflectionProperty
     * @param array $rawValue
     * @param object $ret
     * @return void
     * @throws MismatchingTypesException
     * @throws MissingAttributeException
     * @throws ReflectionException
     * @throws UnsupportedConversionException
     * @throws ValidationException
     * @throws ValueAssignmentException
     */
    protected function setArrayOnProperty(ReflectionProperty $reflectionProperty, array $rawValue, object $ret): void
    {
        if (!is_null($reflectionProperty->getType()->getName()) && $reflectionProperty->getType()->getName() != "array") {
            throw new MismatchingTypesException("The property {$reflectionProperty->getName()} cannot be mapped to the type data received in the json");
        }

        /** @var JsonPropertyType|null $arrayOfType */
        $arrayOfType = $this->getReflectedPropertyAttribute($reflectionProperty, JsonPropertyType::class);

        if (!$arrayOfType) {
            throw new MissingAttributeException("The property {$reflectionProperty->getName()} is missing the attribute JsonPropertyType");
        }

        $arr = [];
        foreach ($rawValue as $item) {
            if (is_scalar($item)) {
                $arr[] = $item;
            } else if (is_object($item)) {
                $arr[] = $this->handleUnmarshal($item, new ReflectionClass($arrayOfType->getType()));
            } else {
                throw new UnsupportedConversionException("Type " . gettype($item) . " is not supported when unmarshalling. Property: {$reflectionProperty->getName()}");
            }
        }

        $this->setValueOnProperty($reflectionProperty, $arr, $ret);
    }

    /**
     * @param ReflectionProperty $reflectionProperty
     * @param mixed $rawValue
     * @param object $ret
     * @return void
     * @throws MismatchingTypesException
     * @throws MissingAttributeException
     * @throws ReflectionException
     * @throws UnsupportedConversionException
     * @throws ValidationException
     * @throws ValueAssignmentException
     */
    protected function setObjectOnProperty(ReflectionProperty $reflectionProperty, mixed $rawValue, object $ret): void
    {
        // Try to get from original property type
        $propertyType = $reflectionProperty->getType()?->getName();

        // If none, check from annotation
        if (!$propertyType) {

            /** @var JsonPropertyType|null $objectOfType */
            $objectOfType = $this->getReflectedPropertyAttribute($reflectionProperty, JsonPropertyType::class);

            // If none, then can't proceed
            if (!$objectOfType) {
                throw new MissingAttributeException("The property {$reflectionProperty->getName()} is missing a defined Type or the attribute JsonPropertyType");
            }

            $propertyType = $objectOfType->getType();
        }

        $value = $this->handleUnmarshal($rawValue, new ReflectionClass($propertyType));

        $this->setValueOnProperty($reflectionProperty, $value, $ret);
    }

    /**
     * @param ReflectionProperty $reflectionProperty
     * @param mixed $value
     * @param object $ret
     * @return void
     * @throws ValueAssignmentException
     */
    protected function setValueOnProperty(ReflectionProperty $reflectionProperty, mixed &$value, object $ret): void
    {
        $methodName = "set" . ucfirst($reflectionProperty->getName());
        if (method_exists($ret, $methodName)) {
            $ret->{$methodName}($value);
        } else if ($reflectionProperty->isPublic()) {
            $ret->{$reflectionProperty->getName()} = $value;
        } else {
            throw new ValueAssignmentException("Property {$reflectionProperty->getName()} is not public and there is no method called $methodName available.");
        }
    }

}