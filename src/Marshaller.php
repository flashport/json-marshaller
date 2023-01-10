<?php namespace JsonMarshaller;

use JsonMarshaller\Traits\GetsReflectedPropertyAttributes;

class Marshaller{

    use GetsReflectedPropertyAttributes;

    /**
     * @param object $object
     * @return string
     */
    public function marshal(object $object) : string
    {
        return json_encode($object);
    }

}