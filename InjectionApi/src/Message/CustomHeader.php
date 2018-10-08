<?php
namespace Socketlabs\Message;
/**
 * Used to  create, manage and manipulate custom headers for messages
 */
class CustomHeader{
    
    /**
     * The name of the custom header
     */
    public $name;

    /**
     * The value of the custom header
     */
    public $value;

    /**
     * Create a new instance of CustomHeader
     * @param string $name
     * @param string $value
     */
    public function __construct($name, $value){
        $this->name = $name;
        $this->value = $value;
    }
}