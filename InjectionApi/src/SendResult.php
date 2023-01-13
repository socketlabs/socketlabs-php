<?php

/**
 * Enumerated result of the client send
 */

namespace Socketlabs;

abstract class SendResult
{

    /**
     * An error has occured that was unforeseen
     */
    const UnknownError = "UnknownError";

    /**
     * A timeout occurred sending the message
     */
    const Timeout = "Timeout";

    /**
     * Successful send of message
     */
    const Success = "Success";

    /**
     * Warnings were found while sending the message
     */
    const Warning = "Warning";

    /**
     * Internal server error
     */
    const InternalError = "InternalError";

    /**
     * Message size has exceeded the size limit
     */
    const MessageTooLarge = "MessageTooLarge";

    /**
     * Message exceeded maximum recipient count in the message
     */
    const TooManyRecipients = "TooManyRecipients";

    /**
     * Invalid data was found on the message
     */
    const InvalidData = "InvalidData";

    /**
     * The account is over the send quota, rate limit exceeded
     */
    const OverQuota = "OverQuota";

    /**
     * Too many errors occurred sending the message
     */
    const TooManyErrors = "TooManyErrors";

    /**
     * The ServerId/ApiKey combination is invalid
     */
    const InvalidAuthentication = "InvalidAuthentication";

    /**
     * The account has been disabled
     */
    const AccountDisabled = "AccountDisabled";

    /**
     * Too many messages were found in the request
     */
    const TooManyMessages = "TooManyMessages";

    /**
     * No valid recipients were found in the message
     */
    const NoValidRecipients = "NoValidRecipients";

    /**
     * An invalid recipient were found on the message
     */
    const InvalidAddress = "InvalidAddress";

    /**
     * An invalid attachment were found on the message
     */
    const InvalidAttachment = "InvalidAttachment";

    /**
     * No message body was found in the message
     */
    const NoMessages = "NoMessages";

    /**
     * No message body was found in the message
     */
    const EmptyMessage = "EmptyMessage";

    /**
     * No subject was found in the message
     */
    const EmptySubject = "EmptySubject";

    /**
     * An invalid from address was found on the message
     */
    const InvalidFrom = "InvalidFrom";

    /**
     * No To addresses were found in the message
     */
    const EmptyToAddress = "EmptyToAddress";

    /**
     * No valid message body was found in the message
     */
    const NoValidBodyParts = "NoValidBodyParts";

    /**
     * An invalid TemplateId was found in the message
     */
    const InvalidTemplateId = "InvalidTemplateId";

    /**
     * The specified TemplateId has no content for the message
     */
    const TemplateHasNoContent = "TemplateHasNoContent";

    /**
     * A conflict occurred on the message body of the message
     */
    const MessageBodyConflict = "MessageBodyConflict";

    /**
     * Invalid MergeData was found on the message
     */
    const InvalidMergeData = "InvalidMergeData";

    /**
     * Authentication Error, Missing or invalid ServerId or ApiKey
     */
    const AuthenticationValidationFailed = "AuthenticationValidationFailed";

    /**
     * From email address is missing in the message
     */
    const EmailAddressValidationMissingFrom = "EmailAddressValidationMissingFrom";

    /**
     * From email address in the message in invalid
     */
    const EmailAddressValidationInvalidFrom = "EmailAddressValidationInvalidFrom";

    /**
     * Message exceeded maximum recipient count in the message
     */
    const RecipientValidationMaxExceeded = "RecipientValidationMaxExceeded";

    /**
     * No recipients were found in the message
     */
    const RecipientValidationNoneInMessage = "RecipientValidationNoneInMessage";

    /**
     * To addresses are missing in the message
     */
    const RecipientValidationMissingTo = "RecipientValidationMissingTo";

    /**
     * Invalid ReplyTo address found
     */
    const RecipientValidationInvalidReplyTo = "RecipientValidationInvalidReplyTo";

    /**
     * Invalid recipients found
     */
    const RecipientValidationInvalidRecipients = "RecipientValidationInvalidRecipients";

    /**
     * No subject was found in the message
     */
    const MessageValidationEmptySubject = "MessageValidationEmptySubject";

    /**
     * No message body was found in the message
     */
    const MessageValidationEmptyMessage = "MessageValidationEmptyMessage";

    /**
     * Invalid custom headers found
     */
    const MessageValidationInvalidCustomHeaders = "MessageValidationInvalidCustomHeaders";

    /**
     * Invalid metadata found
     */
    const MessageValidationInvalidMetadata = "MessageValidationInvalidMetadata";

    /**
     * Invalid metadata found
     */
    const MessageValidationInvalidTag = "MessageValidationInvalidTag";

    /**
     * Get a value for a given name
     * @param $name
     * @return SendResult
     */
    public static function get_const($name)
    {
        $constant = 'self::' . $name;
        if (defined($constant)) {
            return constant($constant);
        } else {
            return false;
        }
    }
}
