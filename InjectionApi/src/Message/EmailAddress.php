<?php
namespace Socketlabs\Message;
/**
 * Represents an individual email address for a message.
 */
class EmailAddress{
    
    /**
     * A valid email address
     */
    public $emailAddress;

    /**
     * The friendly or display name for the recipient.
     */
    public $friendlyName;

    /**
     * Creates a new instance of the EmailAddress class.
     * @param string $emailAddress
     * @param string $friendlyName
     */
    public function __construct($emailAddress, $friendlyName = null){
        $this->emailAddress = $emailAddress;
        if($friendlyName) $this->friendlyName = $friendlyName;
    }

    /**
     * Determines if the Email Address is valid.
     * @return boolean
     */
    public function isValid(){
        $email = $this->emailAddress;
        if(is_string($email) && !ctype_space($email) && $email != "")
        {
            $parts = explode("@", $email);
            if( count($parts) == 2   &&
                strlen($email) < 320  &&
                strlen($parts[0]) > 1 &&
                strlen($parts[1]) > 1){
                return true;
            }
        }
        return false;
    }
}