<?php

namespace Tests\Unit\Marshal;

use JsonMarshaller\Exceptions\JsonMarshallerException;
use JsonMarshaller\Exceptions\ValidationException;
use ReflectionException;
use Tests\Data\Objects\Address;
use Tests\Data\Objects\Gender;
use Tests\Data\Objects\PersonWithIgnoredProperty;
use Tests\Unit\BaseTestCase;

class IgnorePropertyTest extends BaseTestCase
{

    /**
     * @test
     * @return void
     * @throws ReflectionException
     * @throws ValidationException
     * @throws JsonMarshallerException
     */
    public function it_marshals_nested_objects_with_ignored_properties(): void
    {
        $address = new Address();
        $address->street = "Nice Street";
        $address->number = 10;
        $address->zip = 12345;
        $address->city = "New York";

        $person = new PersonWithIgnoredProperty();
        $person->name = "John Doe";
        $person->emailAddress = "john.doe@email.com";
        $person->address = $address;
        $person->gender = Gender::MALE;
        // This property should be ignored
        $person->age = 30;

        $json = $this->jsonMarshaller->marshal($person);

        $file = json_encode(json_decode($this->getJsonFile("person.json")));

        $this->assertEquals($file, $json);
    }
}