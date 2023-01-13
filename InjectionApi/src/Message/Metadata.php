<?php

namespace Socketlabs\Message;

/**
 * Used to  create, manage and manipulate Metadata for messages
 */
class Metadata
{

    /**
     * The name of the Metadata
     */
    public $name;

    /**
     * The value of the Metadata
     */
    public $value;

    /**
     * Create a new instance of Metadata
     * @param string $name
     * @param string $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
}
