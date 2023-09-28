<?php

namespace Tests\Unit\Marshal;

use JsonMarshaller\Exceptions\JsonMarshallerException;
use JsonMarshaller\Exceptions\ValidationException;
use ReflectionException;
use Tests\Data\Objects\Address;
use Tests\Data\Objects\Gender;
use Tests\Data\Objects\Person;
use Tests\Unit\BaseTestCase;

class NestedObjectsTest extends BaseTestCase
{
    /**
     * @return Address
     */
    protected function createTestAddress(): Address
    {
        $address = new Address();
        $address->street = "Nice Street";
        $address->number = 10;
        $address->zip = 12345;
        $address->city = "New York";

        return $address;
    }

    /**
     * @return Person
     */
    protected function createTestPerson(): Person
    {
        $person = new Person();
        $person->name = "John Doe";
        $person->emailAddress = "john.doe@email.com";
        $person->address = $this->createTestAddress();
        $person->gender = Gender::MALE;

        return $person;
    }

    /**
     * @test
     * @return void
     * @throws ReflectionException
     * @throws ValidationException
     * @throws JsonMarshallerException
     */
    public function it_marshals_nested_objects(): void
    {
        $person = $this->createTestPerson();

        $json = $this->jsonMarshaller->marshal($person);

        $file = json_encode(json_decode($this->getJsonFile("person.json")));

        $this->assertEquals($file, $json);
    }
}