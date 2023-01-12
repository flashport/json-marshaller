<?php namespace JsonMarshaller;

class JsonMarshallerFlags
{
    // Whenever (un)marshalling, if there is an error, it will just return null
    const RETURN_NULL_ON_ERROR = "return_null_on_error";

    // If an object property is private/protected and there is no getter, it will be fetched anyway
    const ACCESS_PRIVATE_PROPERTIES = "access_private_properties";
}