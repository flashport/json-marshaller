# JSON Marshaller

---

This lib provides marshalling and unmarshalling functionality, allowing 
JSON strings to be cast into objects or vice versa.

### Usage:

Object example:
```php
class Person{

    // It supports custom property names
    #[JsonProperty("fullName")]
    public string $name;
    
    // It also supports validation attributes
    #[JsonValidateRequired]
    public string $email;
    
    // Equals can be a single value or an array
    #[JsonValidateEquals(["active", "inactive"])]
    public string $status;
    
    // It is necessary to define the array type
    #[JsonPropertyType(Address::class)]
    public array $addresses;
    
    // For array with scalar types
    #[JsonPropertyType(ScalarTypes::INTEGER)]
    public array $luckyNumbers;
    
    // The type can be inferred from the property, or from the attribute.
    // At least one is required
    public Address $billingAddress;
    
    #[JsonPropertyType(Address::class)]
    public $shippingAddress;
}
```

Marshalling:
```php
$json = new \JsonMarshaller\JsonMarshaller();
$jsonString = $json->marshal($myObject);
```

Unmarshalling:
```php

$json = new \JsonMarshaller\JsonMarshaller();
$person = $json->unmarshal($jsonString, Person::class)
```

