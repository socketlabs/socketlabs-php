<?php
namespace Socketlabs\Core\Serialization;
/**
 * Represents MergeData for a single message.
 * To be serialized into JSON string before sending to the Injection Api.
 */
class MergeDataJson {
 
    /**
     * Defines merge field data for all messages in the request.
     */
    public $Global;

    /**
     * Defines merge field data for each message.
     */
    public $PerMessage;

    /**
     * Creates a new instance of the Socketlabs\Core\Serialization\MergeDataJson class.
     */
    public function __construct()
    {
        $this->Global = array();
        $this->PerMessage = array(array()); 
    }
}