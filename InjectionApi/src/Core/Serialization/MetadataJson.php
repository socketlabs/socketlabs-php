<?php

namespace Socketlabs\Core\Serialization;

/**
 * Represents a metadata as a name and value pair.
 * To be serialized into JSON string before sending to the Injection Api.
 */
class MetadataJson
{

    /**
     * Gets or sets the metadata name.
     */
    public $Name;

    /**
     * Gets or sets the metadata value.
     */
    public $Value;

    /**
     * Creates a new instance of the MetadataJson class and sets the name and value pair.
     * @param string $name The name of your metadata.
     * @param string $value The value for your metadata.
     */
    public function __construct($name, $value)
    {
        $this->Name = $name;
        $this->Value = $value;
    }
}
