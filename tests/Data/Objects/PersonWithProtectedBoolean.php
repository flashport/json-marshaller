<?php namespace Tests\Data\Objects;

class PersonWithProtectedBoolean
{

    public string $name;

    public string $emailAddress;

    public Address $address;

    protected bool $active;

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

}