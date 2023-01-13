<?php

namespace Socketlabs\Core\Serialization;

/**
 * Represents a message for sending to the Injection Api.
 * To be serialized into JSON string before sending to the Injection Api.
 */
class MessageJson
{

    /**
     * Gets or sets the list of To recipients.
     */
    public $To = array();

    /**
     * Gets or sets the list of CC recipients.
     */
    public $Cc = array();

    /**
     * Gets or sets the list of BCC recipients.
     */
    public $Bcc = array();

    /**
     * Gets or sets the From address.
     */
    public $From;

    /**
     * Gets or sets the instance of the message Subject.
     */
    public $Subject;

    /**
     * Gets or sets the list of merge data.
     */
    public $MergeData;

    /**
     * Gets or sets the plain text portion of the message body.
     */
    public $TextBody;

    /**
     * Gets or sets the HTML portion of the message body.
     */
    public $HtmlBody;

    /**
     * Gets or sets the Api Template for the message.
     */
    public $ApiTemplate;

    /**
     * Gets or sets the custom MailingId for the message.
     */
    public $MailingId;

    /**
     * Gets or sets the custom MessageId for the message.
     */
    public $MessageId;

    /**
     * The optional character set for your message.
     */
    public $CharSet;

    /**
     * Gets or sets the Reply To address.
     */
    public $ReplyTo;

    /**
     * Gets or sets the list of attachments.
     */
    public $Attachments = array();


    /**
     * A list of custom message headers added to the message.
     */
    public $CustomHeaders = array();

    /**
     * A list of metadata added to the message.
     */
    public $Metadata = array();

    /**
     * A list of tags added to the message.
     */
    public $Tags = array();

    /**
     * Creates a new instance of the MessageJson class.
     */
    public function __construct()
    {
        $this->MergeData = new MergeDataJson();
    }
}
