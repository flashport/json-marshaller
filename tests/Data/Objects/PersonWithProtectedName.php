<?php namespace Tests\Data\Objects;

class PersonWithProtectedName
{

    protected string $name;

    public string $emailAddress;

    public Address $address;

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = "$name Setter";
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "$this->name Getter";
    }

}