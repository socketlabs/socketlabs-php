<?php
namespace Socketlabs\Core\Serialization;
/**
 * Represents a custom header as a name and value pair.
 * To be serialized into JSON string before sending to the Injection Api.
 */
class CustomHeadersJson  {
 
    /**
     * Gets or sets the custom header name.
     */
    public $Name;

    /**
     * Gets or sets the custom header value.
     */
    public $Value;

    /**
     * Creates a new instance of the CustomHeaderJson class and sets the name and value pair.
     * @param string $name The name of your custom header.
     * @param string $value The value for your custom header.
     */
    public function __construct($name, $value)
    {
        $this->Name = $name;
        $this->Value = $value; 
    } 
}