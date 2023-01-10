<?php namespace JsonMarshaller;

use Exception;
use JsonMarshaller\Exceptions\MismatchingTypesException;
use JsonMarshaller\Exceptions\MissingAttributeException;
use JsonMarshaller\Exceptions\UnsupportedConversionException;
use JsonMarshaller\Exceptions\ValidationException;
use JsonMarshaller\Exceptions\ValueAssignmentException;
use ReflectionException;

class JSON{

    protected Marshaller $marshaller;

    protected Unmarshaller $unmarshaller;

    public function __construct()
    {
        $this->marshaller = new Marshaller();
        $this->unmarshaller = new Unmarshaller();
    }


    /**
     * @param object $object
     * @return string
     */
    public function marshal(object $object) : string
    {
        return $this->marshaller->marshal($object);
    }

    /**
     * @param string $json
     * @param string $targetClass
     * @return object|array
     * @throws MismatchingTypesException
     * @throws MissingAttributeException
     * @throws UnsupportedConversionException
     * @throws ValueAssignmentException
     * @throws ReflectionException
     * @throws ValidationException
     */
    public function unmarshal(string &$json, string $targetClass) : object|array
    {
        return $this->unmarshaller->unmarshal($json, $targetClass);
    }
}