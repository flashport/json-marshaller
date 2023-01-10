<?php

namespace Tests\Unit\Marshal;

use JsonMarshaller\Exceptions\ValidationException;
use ReflectionException;
use Tests\Data\Objects\Address;
use Tests\Data\Objects\PersonWithNamedProperty;
use Tests\Data\Objects\PersonWithProtectedName;
use Tests\Unit\BaseTestCase;

class GetterTest extends BaseTestCase
{

    /**
     * @test
     * @return void
     * @throws ValidationException
     * @throws ReflectionException
     */
    public function it_marshals_nested_objects_with_named_properties(): void
    {
        $address = new Address();
        $address->street = "Nice Street";
        $address->number = 10;
        $address->zip = 12345;
        $address->city = "New York";

        $person = new PersonWithProtectedName();
        $person->setName("John Doe");
        $person->emailAddress = "john.doe@email.com";
        $person->address = $address;

        $json = $this->jsonMarshaller->marshal($person);

        $file = json_encode(json_decode($this->getJsonFile("person.json")));

        $this->assertNotEquals($file, $json);
    }
}