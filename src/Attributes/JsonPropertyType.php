<?php namespace JsonMarshaller\Attributes;

use Attribute;

#[Attribute]
class JsonPropertyType{


    protected string $type;

    /**
     * @param string $type
     */
    public function __construct(string $type)
    {
        $this->type = $type;
    }


    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }



}