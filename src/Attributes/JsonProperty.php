<?php namespace JsonMarshaller\Attributes;

use Attribute;

#[Attribute]
class JsonProperty{


    protected string $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }



}