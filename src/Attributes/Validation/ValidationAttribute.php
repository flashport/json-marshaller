<?php namespace JsonMarshaller\Attributes\Validation;

 interface ValidationAttribute{

     /**
      * Validates the value that will be either fetched from or set into the attribute
      *
      * @param mixed $value
      * @return mixed
      */
     public function isValid(mixed &$value) : bool;

 }