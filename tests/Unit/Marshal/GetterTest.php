<?php

namespace Tests\Unit\Marshal;

use JsonMarshaller\Exceptions\ValidationException;
use JsonMarshaller\JsonMarshaller;
use JsonMarshaller\JsonMarshallerFlags;
use ReflectionException;
use Tests\Data\Objects\Address;
use Tests\Data\Objects\PersonWithoutGetter;
use Tests\Data\Objects\PersonWithProtectedBoolean;
use Tests\Data\Objects\PersonWithProtectedName;
use Tests\Unit\BaseTestCase;

class GetterTest extends BaseTestCase
{


    protected function createAddress() : Address
    {
        $address = new Address();
        $address->street = "Nice Street";
        $address->number = 10;
        $address->zip = 12345;
        $address->city = "New York";

        return $address;
    }

    /**
     * @test
     * @return void
     * @throws ValidationException
     * @throws ReflectionException
     */
    public function it_marshals_nested_objects_with_named_properties(): void
    {
        $person = new PersonWithProtectedName();
        $person->setName("John Doe");
        $person->emailAddress = "john.doe@email.com";
        $person->address = $this->createAddress();

        $json = $this->jsonMarshaller->marshal($person);

        $file = json_encode(json_decode($this->getJsonFile("person.json")));

        $this->assertNotEquals($file, $json);
    }

    /**
     * @test
     * @return void
     * @throws ReflectionException
     * @throws ValidationException
     */
    public function it_marshals_using_booleans_getters(): void
    {
        $person = new PersonWithProtectedBoolean();
        $person->name = "John Doe";
        $person->emailAddress = "john.doe@email.com";
        $person->address = $this->createAddress();
        $person->setActive(true);

        $json = $this->jsonMarshaller->marshal($person);
        $rawDecoded = json_decode($json);

        $this->assertNotEmpty(property_exists($rawDecoded, 'active') ? $rawDecoded->active : null);
    }
    /**
     * @test
     * @return void
     * @throws ReflectionException
     * @throws ValidationException
     */
    public function it_has_access_to_private_properties(): void
    {
        $person = new PersonWithoutGetter();
        $person->setName("John Doe");
        $person->emailAddress = "john.doe@email.com";
        $person->address = $this->createAddress();

        $this->jsonMarshaller = new JsonMarshaller(JsonMarshallerFlags::ACCESS_PRIVATE_PROPERTIES);

        $json = $this->jsonMarshaller->marshal($person);
        $rawDecoded = json_decode($json);


        $this->assertNotEmpty(property_exists($rawDecoded, 'name') ? $rawDecoded->name : null);
    }

}