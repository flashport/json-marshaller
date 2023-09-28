<?php

namespace Tests\Unit\Marshal;

use JsonMarshaller\Exceptions\JsonMarshallerException;
use JsonMarshaller\Exceptions\ValidationException;
use ReflectionException;
use Tests\Data\Objects\Address;
use Tests\Data\Objects\Gender;
use Tests\Data\Objects\PersonWithNamedProperty;
use Tests\Unit\BaseTestCase;

class NamedPropertyTest extends BaseTestCase
{

    /**
     * @test
     * @return void
     * @throws ReflectionException
     * @throws ValidationException
     * @throws JsonMarshallerException
     */
    public function it_marshals_nested_objects_with_named_properties(): void
    {
        $address = new Address();
        $address->street = "Nice Street";
        $address->number = 10;
        $address->zip = 12345;
        $address->city = "New York";

        $person = new PersonWithNamedProperty();
        $person->name = "John Doe";
        $person->email = "john.doe@email.com";
        $person->address = $address;
        $person->gender = Gender::MALE;

        $json = $this->jsonMarshaller->marshal($person);

        $file = json_encode(json_decode($this->getJsonFile("person.json")));

        $this->assertEquals($file, $json);
    }
}