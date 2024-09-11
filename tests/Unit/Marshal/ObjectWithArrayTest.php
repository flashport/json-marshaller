<?php

namespace Tests\Unit\Marshal;

use JsonMarshaller\Exceptions\JsonMarshallerException;
use JsonMarshaller\Exceptions\ValidationException;
use ReflectionException;
use Tests\Data\Objects\Address;
use Tests\Data\Objects\ArrayOfObjects;
use Tests\Data\Objects\KeyValueStore;
use Tests\Unit\BaseTestCase;

class ObjectWithArrayTest extends BaseTestCase
{

    /**
     * @test
     * @return void
     * @throws ReflectionException
     * @throws ValidationException
     * @throws JsonMarshallerException
     */
    public function it_marshals_an_object_with_array(): void
    {
        $keyValueStore = new KeyValueStore([
            "key1" => "value1",
            "key2" => "value2",
            "key3" => "value3",
        ]);


        $json = $this->jsonMarshaller->marshal($keyValueStore);

        $file = json_encode(json_decode($this->getJsonFile("key-value-store.json")));

        $this->assertEquals($file, $json);
    }
}