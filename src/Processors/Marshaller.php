<?php namespace JsonMarshaller\Processors;

use JsonMarshaller\Attributes\JsonProperty;
use JsonMarshaller\Exceptions\JsonMarshallerException;
use JsonMarshaller\Exceptions\ValidationException;
use JsonMarshaller\Resources\ScalarTypes;
use JsonSerializable;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use stdClass;

class Marshaller extends BaseProcessor
{
    
    /**
     * @param object|array $data
     * @return string
     * @throws JsonMarshallerException
     * @throws ReflectionException
     * @throws ValidationException
     */
    public function marshal(object|array $data): string
    {
        try {
            
            // Bypass handling
            if($data instanceof JsonSerializable){
                return $data->jsonSerialize();
            }
            
            // Single item handling
            if (is_object($data)) {
                $reflectionClass = new ReflectionClass($data);
                return json_encode($this->handleMarshal($data, $reflectionClass));
            }
            
            // Array handling
            $ret = [];
            foreach ($data as $item) {
                $reflectionClass = new ReflectionClass($data[0]);
                $ret[] = $this->handleMarshal($item, $reflectionClass);
            }
            
            return json_encode($ret);
            
        } catch (JsonMarshallerException $e) {
            return $this->shouldReturnNullOnErrors() ? "" : throw $e;
        }
    }
    
    
    /**
     * @param object $object
     * @param ReflectionClass $reflectionClass
     * @return object
     * @throws ReflectionException
     * @throws ValidationException
     */
    protected function handleMarshal(object $object, ReflectionClass $reflectionClass): object
    {
        $shadow = new stdClass();
        
        foreach ($reflectionClass->getProperties() as $reflectionProperty) {
            
            if ($this->shouldIgnoreProperty($reflectionProperty)) {
                continue;
            }
            
            $propertyName = $this->getPropertyName($reflectionProperty);
            $propertyValue = $this->getPropertyValue($object, $reflectionProperty);
            
            $this->validateReflectedProperty($reflectionProperty, $propertyValue);
            
            if (empty($propertyValue)) {
                continue;
            } else if ($propertyValue instanceof JsonSerializable) {
                $shadow->{$propertyName} = json_decode($propertyValue->jsonSerialize());
            } else if (is_object($propertyValue)) {
                $this->setObjectOnProperty($propertyName, $propertyValue, $shadow);
            } else if (is_array($propertyValue)) {
                $this->setArrayOnProperty($propertyName, $propertyValue, $shadow);
            } else {
                $shadow->{$propertyName} = $propertyValue;
            }
        }
        return $shadow;
    }
    
    /**
     * @param string $propertyName
     * @param object $propertyValue
     * @param stdClass $shadow
     * @return void
     * @throws ReflectionException
     * @throws ValidationException
     */
    protected function setObjectOnProperty(string $propertyName, object $propertyValue, stdClass $shadow): void
    {
        $shadow->{$propertyName} = $this->handleMarshal($propertyValue, new ReflectionClass($propertyValue));
    }
    
    /**
     * @param string $propertyName
     * @param array $propertyValue
     * @param stdClass $shadow
     * @return void
     * @throws ReflectionException
     * @throws ValidationException
     */
    protected function setArrayOnProperty(string $propertyName, array $propertyValue, stdClass $shadow): void
    {
        $arr = [];
        foreach ($propertyValue as $item) {
            $arr[] = is_object($item) ?
                $this->handleMarshal($item, new ReflectionClass($item)) :
                $item;
        }
        
        $shadow->{$propertyName} = $arr;
    }
    
    /**
     * @param ReflectionProperty $reflectionProperty
     * @return string
     */
    protected function getPropertyName(ReflectionProperty $reflectionProperty): string
    {
        /** @var JsonProperty $jsonProperty */
        $jsonProperty = $this->getReflectedPropertyAttribute($reflectionProperty, JsonProperty::class);
        
        return $jsonProperty?->getName() ?? $reflectionProperty->getName();
    }
    
    /**
     * @param object $object
     * @param ReflectionProperty $reflectionProperty
     * @return mixed
     */
    protected function getPropertyValue(object $object, ReflectionProperty $reflectionProperty): mixed
    {
        $methodPrefix = $reflectionProperty->getType()->getName() == ScalarTypes::BOOLEAN ? "is" : "get";
        $methodName = $methodPrefix . ucfirst($reflectionProperty->getName());
        if (method_exists($object, $methodName)) {
            $ret = $object->{$methodName}();
            return is_object($ret) && enum_exists($ret::class) ? $ret->value : $ret;
        } else if ($reflectionProperty->isPublic()) {
            
            if (enum_exists($reflectionProperty->getType()->getName())) {
                return $object->{$reflectionProperty->getName()}->value;
            }
            
            return $object->{$reflectionProperty->getName()} ?? null;
        } else if ($this->shouldAccessPrivateProperties()) {
            return $this->getPrivatePropertyValue($object, $reflectionProperty);
        }
        
        return null;
    }
}