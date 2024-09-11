<?php

namespace Tests\Unit\Unmarshal;

use JsonMarshaller\Exceptions\JsonMarshallerException;
use JsonMarshaller\Exceptions\MismatchingTypesException;
use JsonMarshaller\Exceptions\MissingAttributeException;
use JsonMarshaller\Exceptions\UnsupportedConversionException;
use JsonMarshaller\Exceptions\ValidationException;
use JsonMarshaller\Exceptions\ValueAssignmentException;
use ReflectionException;
use Tests\Data\Objects\KeyValueStore;
use Tests\Unit\BaseTestCase;

class KeyValueStoreTest extends BaseTestCase
{
    
    /**
     * @test
     * @return void
     * @throws MismatchingTypesException
     * @throws MissingAttributeException
     * @throws ReflectionException
     * @throws UnsupportedConversionException
     * @throws ValidationException
     * @throws ValueAssignmentException
     * @throws JsonMarshallerException
     */
    public function it_unmarshals_key_value_stores(): void
    {
        $file = $this->getJsonFile("key-value-store.json");

        /** @var KeyValueStore $keyValueStore */
        $keyValueStore = $this->jsonMarshaller->unmarshal($file, KeyValueStore::class);

        $this->assertEquals(
            json_encode([
                "key1" => "value1",
                "key2" => "value2",
                "key3" => "value3",
            ]),
            $keyValueStore->jsonSerialize()
        );
    }
}