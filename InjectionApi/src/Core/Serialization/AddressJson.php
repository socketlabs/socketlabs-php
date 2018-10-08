<?php
namespace Socketlabs\Core\Serialization;
/**
 * Represents an individual email address for a message.
 * To be serialized into JSON string before sending to the Injection Api.
 */
class AddressJson  {
 
    /**
     * A valid email address
     */
    public $EmailAddress;

    /**
     * The friendly or display name for the recipient.
     */
    public $FriendlyName;

    /**
     * Creates a new instance of the Socketlabs\Core\Serialization\AddressJson class and sets the email address.
     * @param string $emailAddress A valid email address
     * @param string friendlyName The friendly or display name for the recipient.
     */
    public function __construct($emailAddress, $friendlyName)
    {
        $this->EmailAddress = $emailAddress;
        $this->FriendlyName = $friendlyName; 
    } 
}