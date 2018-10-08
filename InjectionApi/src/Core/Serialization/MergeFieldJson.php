<?php
namespace Socketlabs\Core\Serialization;
/**
 * Represents a merge field as a field and value pair.
 * To be serialized into JSON string before sending to the Injection Api.
 */
class MergeFieldJson {
 
    /**
     * Gets or sets the merge field. 
     */
    public $Field;

    /**
     * Gets or sets the merge field value.
     */
    public $Value;

    /**
     * Creates a new instance of the Socketlabs\Core\Serialization\MergeFieldJson class and sets the field and value pair.
     * @param string $field The field of your merge field.
     * @param string @value The value for your merge field.
     */
    public function __construct($field, $value)
    {
        $this->Field = $field;
        $this->Value = $value;
    }
}