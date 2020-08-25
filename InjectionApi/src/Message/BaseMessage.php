<?php
namespace Socketlabs\Message;
/**
 * Contains properties and methods common to all message types.
 */
class BaseMessage{

    /** 
     * Message subject.   
     */
    public $subject;
/**
     * Plain text portion of the message body. 
     * 
     * (Optional)
     * Atleast one of the following body types must be set: $plainTextBody (with ampBody), 
     * $htmlBody (with ampBody), or $apiTemplate.     */
    public $plainTextBody;

    /**
     * HTML portion of the message body.
     * 
     * (Optional)
     * Atleast one of the following body types must be set: $plainTextBody (with ampBody), 
     * $htmlBody (with ampBody), or $apiTemplate.
     */
    public $htmlBody;

    /**
     * Api Template Id used to specify a template to be used for the message Id. 
     * 
     * (Optional)
      * Atleast one of the following body types must be set: $plainTextBody (with ampBody), 
     * $htmlBody (with ampBody), or $apiTemplate.
     */
    public $apiTemplate;

    /**
     * AmpBody Id used to specify a template to be used for the message Id. 
     * 
     * (Optional)
     * Atleast one of the following body types must be set: $plainTextBody (with ampBody), 
     * $htmlBody (with ampBody), or $apiTemplate.    
     */
    public $ampBody;

    /**
     * Custom MailingId for the message.
     * 
     * (Optional)
     * See https://www.socketlabs.com/blog/best-practices-for-using-custom-mailingids-and-messageids/ for more information.
     */
    public $mailingId;

    /**
     * Custom MessageId for the message.
     * 
     * (Optional)
     * See https://www.socketlabs.com/blog/best-practices-for-using-custom-mailingids-and-messageids/ for more information.
     */
    public $messageId;


    /**
     * From address.
     * 
     * (Required)
     */
    public $from;

    /**
     * An optional ReplyTo address for the message.
     */
    public $replyTo;

    /**
     * The optional character set for your message.
     * 
     * (Optional) Default is 'utf-8'
     */
    public $charset;

    /**
     * Optional array of message attachments.
     */
    public $attachments = array();

    /**
     * Optional array of custom headers.
     */
    public $customHeaders = array();

    /**
     * Adds custom header to the message. 
     * 
     * @param string $name Header name.
     * @param string $value Header value.
     * @return BaseMessage Message Instance.
     */
    public function addCustomHeader($name, $value){
        if(!is_string($name)) throw new InvalidArgumentException("The custom header name property must be type string.");
        if(!is_string($value)) throw new InvalidArgumentException("The custom value property must be type string.");
        $customHeader = new CustomHeader($name, $value);
        $this->customHeaders[] = $customHeader; 
        return $this;

    }
}
