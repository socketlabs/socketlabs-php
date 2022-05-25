<?php
namespace Socketlabs\Message;
/**
 * Contains properties and methods common to all message types.
 */
class BaseMessage{

    /**
     * Message subject.
     * @var string|null
     */
    public $subject;

    /**
     * Plain text portion of the message body.
     *
     * (Optional)
     * Atleast one of the following body types must be set: $plainTextBody (with ampBody),
     * $htmlBody (with ampBody), or $apiTemplate.
     * @var string|null
     */
    public $plainTextBody;

    /**
     * HTML portion of the message body.
     *
     * (Optional)
     * Atleast one of the following body types must be set: $plainTextBody (with ampBody),
     * $htmlBody (with ampBody), or $apiTemplate.
     * @var string|null
     */
    public $htmlBody;

    /**
     * Api Template Id used to specify a template to be used for the message Id.
     *
     * (Optional)
      * Atleast one of the following body types must be set: $plainTextBody (with ampBody),
     * $htmlBody (with ampBody), or $apiTemplate.
     * @var string|null
     */
    public $apiTemplate;

    /**
     * AmpBody Id used to specify a template to be used for the message Id.
     *
     * (Optional)
     * Atleast one of the following body types must be set: $plainTextBody (with ampBody),
     * $htmlBody (with ampBody), or $apiTemplate.
     * @var string|null
     */
    public $ampBody;

    /**
     * Custom MailingId for the message.
     *
     * (Optional)
     * See https://www.socketlabs.com/blog/best-practices-for-using-custom-mailingids-and-messageids/ for more information.
     * @var string|null
     */
    public $mailingId;

    /**
     * Custom MessageId for the message.
     *
     * (Optional)
     * See https://www.socketlabs.com/blog/best-practices-for-using-custom-mailingids-and-messageids/ for more information.
     * @var string|null
     */
    public $messageId;


    /**
     * From address.
     *
     * (Required)
     * @var EmailAddress|null
     */
    public $from;

    /**
     * An optional ReplyTo address for the message.
     * @var EmailAddress|null
     */
    public $replyTo;

    /**
     * The optional character set for your message.
     *
     * (Optional) Default is 'utf-8'
     * @var string|null
     */
    public $charset;

    /**
     * Optional array of message attachments.
     * @var Attachment[]
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
     * @return static Message Instance.
     */
    public function addCustomHeader($name, $value){
        if(!is_string($name)) throw new InvalidArgumentException("The custom header name property must be type string.");
        if(!is_string($value)) throw new InvalidArgumentException("The custom value property must be type string.");
        $customHeader = new CustomHeader($name, $value);
        $this->customHeaders[] = $customHeader;
        return $this;

    }
}
