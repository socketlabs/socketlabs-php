<?php
namespace Socketlabs\Core\Serialization;
/**
 * Represents a message attachment in the form of a byte array.
 * To be serialized into JSON string before sending to the Injection Api.
 */
class AttachmentJson  {
  
    /**
     * Name of attachment (displayed in email clients)
     */
    public $Name;

    /**
     * The BASE64 encoded string containing the contents of an attachment.
     */
    public $Content;

    /**
     * When set, used to embed an image within the body of an email message.
     */
    public $ContentId;

    /**
     * The ContentType (MIME type) of the attachment.
     */
    public $ContentType;

    /**
     * A list of custom headers added to the attachment.
     */
    public $CustomHeaders; 
}