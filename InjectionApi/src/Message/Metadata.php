<?php

namespace Socketlabs\Message;

/**
 * Used to  create, manage and manipulate Metadata for messages
 */
class Metadata
{

    /**
     * The key of the Metadata
     */
    public $key;

    /**
     * The value of the Metadata
     */
    public $value;

    /**
     * Create a new instance of Metadata
     * @param string $key
     * @param string $value
     */
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}
