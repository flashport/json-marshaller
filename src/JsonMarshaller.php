<?php namespace JsonMarshaller;

use JsonMarshaller\Exceptions\JsonMarshallerException;
use JsonMarshaller\Exceptions\MismatchingTypesException;
use JsonMarshaller\Exceptions\InvalidFlagException;
use JsonMarshaller\Exceptions\MissingAttributeException;
use JsonMarshaller\Exceptions\UnsupportedConversionException;
use JsonMarshaller\Exceptions\ValidationException;
use JsonMarshaller\Exceptions\ValueAssignmentException;
use JsonMarshaller\Processors\Marshaller;
use JsonMarshaller\Processors\Unmarshaller;
use ReflectionException;

class JsonMarshaller
{

    protected Marshaller $marshaller;

    protected Unmarshaller $unmarshaller;

    /**
     * @param string ...$flags
     * @throws InvalidFlagException
     */
    public function __construct(string ...$flags)
    {
        $this->marshaller = new Marshaller(...$flags);
        $this->unmarshaller = new Unmarshaller(...$flags);
    }


    /**
     * @param array|object $object $object
     * @return string
     * @throws JsonMarshallerException
     * @throws ReflectionException
     * @throws ValidationException
     */
    public function marshal(array|object $object): string
    {
        return $this->marshaller->marshal($object);
    }

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
        return $this->unmarshaller->unmarshal($json, $targetClass);
    }
}