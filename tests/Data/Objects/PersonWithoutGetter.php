<?php namespace Tests\Data\Objects;

class PersonWithoutGetter
{

    protected string $name;

    public string $emailAddress;

    public Address $address;

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


}