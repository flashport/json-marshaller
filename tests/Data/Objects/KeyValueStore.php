<?php namespace Tests\Data\Objects;

use JsonMarshaller\Interfaces\JsonUnserializable;
use JsonSerializable;

class KeyValueStore implements JsonSerializable, JsonUnserializable
{
    public array $data;
    
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
    /**
     * @return string
     */
    public function jsonSerialize(): string
    {
        if(! isset($this->data)){
            return "";
        }
        
        return json_encode($this->data);
    }
    
    /**
     * @param string $json
     * @return KeyValueStore
     */
    public static function jsonUnserialize(string $json): KeyValueStore
    {
        return new KeyValueStore(json_decode($json, true));
    }
}