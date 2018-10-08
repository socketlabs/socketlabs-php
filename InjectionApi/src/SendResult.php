<?php
/**
 * Enumerated result of the client send
 */
namespace Socketlabs;
abstract class SendResult{
    
    /**
     * An error has occured that was unforeseen
     */
    const UnknownError = 0;
    
    /**
     * A timeout occurred sending the message
     */
    const Timeout = 1;
    
    /**
     * Successful send of message
     */
    const Success = 2;
    
    /**
     * Warnings were found while sending the message
     */
    const Warning = 3;
    
    /**
     * Internal server error
     */
    const InternalError = 4;
    
    /**
     * Message size has exceeded the size limit
     */
    const MessageTooLarge = 5;
    
    /**
     * Message exceeded maximum recipient count in the message
     */
    const TooManyRecipients = 6;
    
    /**
     * Invalid data was found on the message
     */
    const InvalidData = 7;
    
    /**
     * The account is over the send quota, rate limit exceeded
     */
    const OverQuota = 8;
    
    /**
     * Too many errors occurred sending the message
     */
    const TooManyErrors = 9;
    
    /**
     * The ServerId/ApiKey combination is invalid
     */
    const InvalidAuthentication = 10;
    
    /**
     * The account has been disabled
     */
    const AccountDisabled = 11;
    
    /**
     * Too many messages were found in the request
     */
    const TooManyMessages = 12;
    
    /**
     * No valid recipients were found in the message
     */
    const NoValidRecipients = 13;
    
    /**
     * An invalid recipient were found on the message
     */
    const InvalidAddress = 14;
    
    /**
     * An invalid attachment were found on the message
     */
    const InvalidAttachment = 15;
    
    /**
     * No message body was found in the message
     */
    const NoMessages = 16;
    
    /**
     * No message body was found in the message
     */
    const EmptyMessage = 17;
    
    /**
     * No subject was found in the message
     */
    const EmptySubject = 18;
    
    /**
     * An invalid from address was found on the message
     */
    const InvalidFrom = 19;
    
    /**
     * No To addresses were found in the message
     */
    const EmptyToAddress = 20;
    
    /**
     * No valid message body was found in the message
     */
    const NoValidBodyParts = 21;
    
    /**
     * An invalid TemplateId was found in the message
     */
    const InvalidTemplateId = 22;
    
    /**
     * The specified TemplateId has no content for the message
     */
    const TemplateHasNoContent = 23;
    
    /**
     * A conflict occurred on the message body of the message
     */
    const MessageBodyConflict = 24;
    
    /**
     * Invalid MergeData was found on the message
     */
    const InvalidMergeData = 25;
    
    /**
     * Authentication Error, Missing or invalid ServerId or ApiKey
     */
    const AuthenticationValidationFailed = 26;
    
    /**
     * From email address is missing in the message
     */
    const EmailAddressValidationMissingFrom = 27;
    
    /**
     * From email address in the message in invalid
     */
    const EmailAddressValidationInvalidFrom = 28;
    
    /**
     * Message exceeded maximum recipient count in the message
     */
    const RecipientValidationMaxExceeded = 29;
    
    /**
     * No recipients were found in the message
     */
    const RecipientValidationNoneInMessage = 30;
    
    /**
     * To addresses are missing in the message
     */
    const RecipientValidationMissingTo = 31;
    
    /**
     * Invalid ReplyTo address found
     */
    const RecipientValidationInvalidReplyTo = 32;
    
    /**
     * Invalid recipients found
     */
    const RecipientValidationInvalidRecipients = 33;
    
    /**
     * No subject was found in the message
     */
    const MessageValidationEmptySubject = 34;
    
    /**
     * No message body was found in the message
     */
    const MessageValidationEmptyMessage = 35;
    
    /**
     * Invalid custom headers found
     */
    const MessageValidationInvalidCustomHeaders = 36;
    
    /**
     * Get a value for a given name
     * @param $name 
     * @return SendResult
     */
    public static function get_const($name) {
        $constant = 'self::'.$name;
        if(defined($constant)) {
            return constant($constant);
        }
        else {
            return false;
        }
    }
    
    /**
     * Get the name for a given value
     * @param $value
     * @return string
     */
    public static function get_name($value)
    {
        $class = new ReflectionClass(__CLASS__);
        $constants = array_flip($class->getConstants());

        return $constants[$value];
    }
}