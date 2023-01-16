<?php

namespace Socketlabs\Core\Serialization;

/**
 * Represents a metadata as a key and value pair.
 * To be serialized into JSON string before sending to the Injection Api.
 */
class MetadataJson
{

    /**
     * Gets or sets the metadata key.
     */
    public $Key;

    /**
     * Gets or sets the metadata value.
     */
    public $Value;

    /**
     * Creates a new instance of the MetadataJson class and sets the name and value pair.
     * @param string $Key The key of your metadata.
     * @param string $value The value for your metadata.
     */
    public function __construct($key, $value)
    {
        $this->Key = $key;
        $this->Value = $value;
    }
}
