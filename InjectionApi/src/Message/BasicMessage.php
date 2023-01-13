<?php

namespace Socketlabs\Message;

/**
 * A basic email message similar to one created in a personal email client such as Outlook.
 * This message can have many recipients of different types, such as To, CC, and BCC.  This
 * message does not support merge fields.
 */
class BasicMessage extends BaseMessage
{

    /**
     * Array of To recipients. When adding directly to array, EmailAddress type should be used.
     */
    public $to = array();

    /**
     * Array of CC recipients. When adding directly to array, EmailAddress type should be used.
     */
    public $cc = array();

    /**
     * Array of BCC recipients. When adding directly to array, EmailAddress type should be used.
     */
    public $bcc = array();

    /**
     * Adds recipient to To address array.
     * @param string $emailAddress Recipient's email address.
     * @param string $friendlyName Recipient's friendly name.
     */
    public function addToAddress($emailAddress, $friendlyName = null)
    {
        if (is_string($emailAddress)) {
            $this->to[] = new \Socketlabs\Message\EmailAddress($emailAddress, $friendlyName = null);
        } else if (is_a($emailAddress, "\Socketlabs\Message\EmailAddress")) {
            $this->to[] = $emailAddress;
        } else {
            throw new \InvalidArgumentException("Socketlabs\\Message\\BaseMessage::addToAddress() parameter must be type string or type EmailAddress.");
        }
    }

    /**
     * Adds recipient to CC address array.
     * @param string $emailAddress Recipient's email address.
     * @param string $friendlyName Recipient's friendly name.
     */
    public function addCcAddress($emailAddress, $friendlyName = null)
    {
        if (is_string($emailAddress)) {
            $this->cc[] = new EmailAddress($emailAddress, $friendlyName);
        } else if (is_a($emailAddress, "\Socketlabs\Message\EmailAddress")) {
            $this->cc[] = $emailAddress;
        } else {
            throw new \InvalidArgumentException("Socketlabs\\Message\\BaseMessage::addCcAddress() parameter must be type string or type EmailAddress.");
        }
    }

    /**
     * Adds recipient to BCC address array.
     * @param string $emailAddress Recipient's email address.
     * @param string $friendlyName Recipient's friendly name.
     */
    public function addBccAddress($emailAddress, $friendlyName = null)
    {
        if (is_string($emailAddress)) {
            $this->bcc[] = new EmailAddress($emailAddress, $friendlyName);
        } else if (is_a($emailAddress, "Socketlabs\Message\EmailAddress")) {
            $this->bcc[] = $emailAddress;
        } else {
            throw new \InvalidArgumentException("Socketlabs\\Message\\BaseMessage::addBccAddress() parameter must be type string or type EmailAddress.");
        }
    }
}
