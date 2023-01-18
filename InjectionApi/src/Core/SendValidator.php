<?php

namespace Socketlabs\Core;

use Socketlabs\Message\BulkRecipient;

/**
 * Used by the SocketLabsClient to conduct basic validation on the message before sending to the Injection API.
 */
class SendValidator
{

    /**
     * Maximum recipient threshold
     */
    private static $MaximumRecipientsPerMessage = 50;

    /**
     * Validate the ServerId and Api Key pair prior before sending to the Injection API.
     * @param string $serverId Your SocketLabs ServerId number.
     * @param string $apiKey Your SocketLabs Injection API key.
     * @return \Socketlabs\SendResponse with the validation results
     */
    public static function validateCredentials($serverId, $apiKey)
    {

        $sendResponse = new \Socketlabs\SendResponse();

        if (!is_string($apiKey) || ctype_space($apiKey) || $apiKey == "") {
            $sendResponse->result = \Socketlabs\SendResult::AuthenticationValidationFailed;
        } else if (!is_numeric($serverId) || (int)$serverId <= 0) {
            $sendResponse->result = \Socketlabs\SendResult::AuthenticationValidationFailed;
        } else {
            $sendResponse->result = \Socketlabs\SendResult::Success;
        }

        return $sendResponse;
    }

    /**
     * Validate a basic/bulk email message before sending to the Injection API.
     * @param object $message
     * @return \Socketlabs\SendResponse with the validation results
     */
    public static function validateMessage($message)
    {

        if (is_a($message, "Socketlabs\Message\BasicMessage")) {
            return SendValidator::validateBasicMessage($message);
        } else if (is_a($message, "Socketlabs\Message\BulkMessage")) {
            return SendValidator::validateBulkMessage($message);
        }
        return new \Socketlabs\SendResponse(\Socketlabs\SendResult::InvalidData);
    }

    /**
     * Validate a bulk email message.
     * @param object $message
     * @return \Socketlabs\SendResponse with the validation results
     */
    private static function validateBulkMessage($message)
    {
        $validationResult = SendValidator::validateBaseMessage($message);

        if ($validationResult->result == \Socketlabs\SendResult::Success) {
            foreach ($message->to as &$to) if (is_string($to)) $to = new BulkRecipient($to);

            $allRecipients = $message->to;

            $count = count($allRecipients);

            if ($count <= 0) $validationResult = new \Socketlabs\SendResponse(\Socketlabs\SendResult::RecipientValidationNoneInMessage);

            else if ($count > SendValidator::$MaximumRecipientsPerMessage) $validationResult = new \Socketlabs\SendResponse(\Socketlabs\SendResult::RecipientValidationMaxExceeded);

            else $validationResult = SendValidator::validateRecipients($allRecipients);
        }

        if ($validationResult->result == \Socketlabs\SendResult::Success) {
            $validationResult = SendValidator::validateMergeData($message->to);
        }

        return $validationResult;
    }

    /**
     * Validate a basic email message.
     * @param object $message
     * @return \Socketlabs\SendResponse with the validation results
     */
    private static function validateBasicMessage($message)
    {
        $validationResult = SendValidator::validateBaseMessage($message);

        if ($validationResult->result == \Socketlabs\SendResult::Success) {
            foreach ($message->to as &$to) if (is_string($to)) $to = new EmailAddress($to);
            foreach ($message->cc as &$cc) if (is_string($cc)) $cc = new EmailAddress($cc);
            foreach ($message->bcc as &$bcc) if (is_string($bcc)) $bcc = new EmailAddress($bcc);

            $allRecipients = array_merge($message->to, $message->cc, $message->bcc);

            $count = count($allRecipients);

            if ($count <= 0) $validationResult = new \Socketlabs\SendResponse(\Socketlabs\SendResult::RecipientValidationNoneInMessage);

            else if ($count > SendValidator::$MaximumRecipientsPerMessage) $validationResult = new \Socketlabs\SendResponse(\Socketlabs\SendResult::RecipientValidationMaxExceeded);

            else $validationResult = SendValidator::validateRecipients($allRecipients);
        }

        return $validationResult;
    }

    /**
     * Validate the base email message.
     * @param object $message
     * @return \Socketlabs\SendResponse with the validation results
     */
    private static function validateBaseMessage($message)
    {
        if (!SendValidator::HasSubject($message)) {
            return new \Socketlabs\SendResponse(\Socketlabs\SendResult::MessageValidationEmptySubject);
        } else if (!SendValidator::hasValidFrom($message)) {
            return new \Socketlabs\SendResponse(\Socketlabs\SendResult::EmailAddressValidationInvalidFrom);
        } else if (!SendValidator::hasValidReplyTo($message)) {
            return new \Socketlabs\SendResponse(\Socketlabs\SendResult::RecipientValidationInvalidReplyTo);
        } else if (!SendValidator::hasMessageBody($message)) {
            return new \Socketlabs\SendResponse(\Socketlabs\SendResult::MessageValidationEmptyMessage);
        } else if (!SendValidator::hasValidCustomHeaders($message)) {
            return new \Socketlabs\SendResponse(\Socketlabs\SendResult::MessageValidationInvalidCustomHeaders);
        } else if (!SendValidator::hasValidMetadata($message)) {
            return new \Socketlabs\SendResponse(\Socketlabs\SendResult::MessageValidationInvalidMetadata);
        } else if (!SendValidator::hasValidTags($message)) {
            return new \Socketlabs\SendResponse(\Socketlabs\SendResult::MessageValidationInvalidTag);
        } else {
            return new \Socketlabs\SendResponse(\Socketlabs\SendResult::Success);
        }
    }

    /**
     * Check if the message has a subject
     * @param object $message
     * @return bool
     */
    private static function hasSubject($message)
    {
        $subject = $message->subject;
        if (is_string($subject) && !ctype_space($subject) && $subject != "") return true;
        return false;
    }

    /**
     * Check if the message has a valid From Email Address
     * @param object $message
     * @return bool
     */
    private static function hasValidFrom($message)
    {
        $from = $message->from;
        if ($from == null) return false;
        if (is_a($from, "Socketlabs\Message\EmailAddress") && $from->isValid()) return true;
        return false;
    }

    /**
     * If set, check if a ReplyTo email address is valid
     * @param object $message
     * @return bool
     */
    public static function hasValidReplyTo($message)
    {
        $replyTo = $message->replyTo;
        if ($replyTo == null) return true; //The value is allowed to be null.
        if (is_a($replyTo,  "Socketlabs\Message\EmailAddress") && $replyTo->isValid()) return true;
        return false;
    }

    /**
     * Check if the message has a Message Body
     * If an Api Template is specified it will override the HtmlBody and/or the PlainTextBody.
     * If no Api Template is specified the HtmlBody AND the PlainTextBody must be valid
     * </remarks>
     * @param object $message
     * @return bool
     */
    public static function hasMessageBody($message)
    {
        $hasApiTemplate = SendValidator::HasApiTemplate($message);
        if ($hasApiTemplate === true) {
            //If there is a api template, null out the html and text portions of the message
            $message->htmlBody = null;
            $message->plainTextBody = null;
            return true;
        }
        $htmlBody = $message->htmlBody;
        if (!is_string($htmlBody) || ctype_space($htmlBody) || $htmlBody == "") return false;
        $textBody = $message->plainTextBody;
        if (!is_string($textBody) || ctype_space($textBody) || $textBody == "") return false;
        return true;
    }

    /**
     * Check if an ApiTemplate was specified and is valid
     * @param object $message
     * @return bool
     */
    public static function hasApiTemplate($message)
    {
        $apiTemplate = $message->apiTemplate;
        if (is_numeric($apiTemplate) && (int)$apiTemplate > 0) return true;
        return false;
    }

    /**
     * Check if ICustomHeader in List are valid
     * @param object $customHeaders
     * @return bool
     */
    public static function hasValidCustomHeaders($message)
    {
        $customHeaders = $message->customHeaders;

        if (!is_array($customHeaders)) return false;

        $validCustomHeaders = true;

        while ($validCustomHeaders && $customHeader = current($customHeaders)) {
            if (is_a($customHeader, "Socketlabs\Message\CustomHeader")) {
                $validCustomHeaders = $validCustomHeaders &&
                    SendValidator::not_empty($customHeader->name) &&
                    SendValidator::not_empty($customHeader->value);
            } else {
                $key = key($customHeaders);
                $validCustomHeaders = $validCustomHeaders &&
                    SendValidator::not_empty($key) &&
                    SendValidator::not_empty($customHeader);
            }
            next($customHeaders);
        }
        return $validCustomHeaders;
    }

    /**
     * Check if metadata is valid
     * @param object $message
     * @return boolean
     */
    public static function hasValidMetadata($message)
    {
        $arr = $message->metadata;

        if (!is_array($arr)) return false;

        $validMetadata = true;

        while ($validMetadata && $metadata = current($arr)) {
            if (is_a($metadata, "Socketlabs\Message\Metadata")) {
                $validMetadata = $validMetadata &&
                    SendValidator::not_empty($metadata->key) &&
                    SendValidator::not_empty($metadata->value);
            } else {
                $key = key($arr);
                $validMetadata = $validMetadata &&
                    SendValidator::not_empty($key) &&
                    SendValidator::not_empty($metadata);
            }
            next($arr);
        }
        return $validMetadata;
    }

    /**
     * Check if tags are valid
     * @param object $message
     * @return boolean
     */
    public static function hasValidTags($message)
    {
        $arr = $message->tags;

        if (!is_array($arr)) return false;

        $validTags = true;

        while ($validTags && $tag = current($arr)) {
            $validTags = SendValidator::not_empty($tag);
            next($arr);
        }
        return $validTags;
    }

    /**
     * Validate email recipients for a basic message
     * Checks the To, Cc, and the Bcc recipient fields (List of EmailAddress) for the following:
     * a) At least 1 recipient is in the list.
     * b) Cumulative count of recipients in all 3 lists do not exceed the MaximumRecipientsPerMessage.
     * c) Recipients in lists are valid.
     * If errors are found, the SendResponse will contain the invalid email addresses
     * @param array $recipients
     * @return \Socketlabs\SendResponse with the validation results
     */
    private static function validateRecipients($recipients)
    {

        $invalidRecipients = SendValidator::hasInvalidRecipients($recipients);

        if (count($invalidRecipients) > 0) {
            $returnValue = new \Socketlabs\SendResponse(\Socketlabs\SendResult::RecipientValidationInvalidRecipients);
            $returnValue->addressResults = $invalidRecipients;
            return $returnValue;
        }

        return new \Socketlabs\SendResponse(\Socketlabs\SendResult::Success);
    }

    /**
     * Check all 3 recipient lists To, Cc, and Bcc (List of EmailAddress) for valid email addresses
     * @param \Socketlabs\Message\EmailAddress[] $recipients
     * @return array of AddressResult if an invalid email address is found.
     */
    private static function hasInvalidRecipients($recipients)
    {
        $invalidEmails = array();
        foreach ($recipients as $recipient) {
            if (is_a($recipient, "Socketlabs\Message\EmailAddress") && $recipient->isValid()) {
                continue;
            }
            $addressResult = new \Socketlabs\AddressResult();
            $addressResult->accepted = false;
            $addressResult->errorCode = "InvalidAddress";
            $addressResult->emailAddress = $recipient->emailAddress;

            $invalidEmails[] = $addressResult;
        }
        return $invalidEmails;
    }

    /**
     * Validate an array of BulkRecipient and return an AddressResult for each invalid item.
     * @param array $recipients
     * @return array
     */
    private static function getRecipientsWithInvalidMergeData($recipients)
    {
        $invalidRecipient = array();
        foreach ($recipients as $recipient) {
            $names = array();
            foreach ($recipient->mergeData as $mergeData) {
                if ($mergeData->Name && is_string($mergeData->Name) && is_string($mergeData->Value)) {
                    $names[] = $mergeData->Name;
                } else {
                    $addressResult = new \Socketlabs\AddressResult();
                    $addressResult->accepted = false;
                    $addressResult->errorCode = "InvalidMergeData";
                    $addressResult->emailAddress = $recipient->emailAddress;

                    $invalidRecipient[] = $addressResult;
                    break;
                }
            }
            if (count(SendValidator::array_iunique($names))  !== count($names)) {
                $addressResult = new \Socketlabs\AddressResult();
                $addressResult->accepted = false;
                $addressResult->errorCode = "InvalidMergeData";
                $addressResult->emailAddress = $recipient->emailAddress;

                $invalidRecipient[] = $addressResult;
            }
        }
        return $invalidRecipient;
    }

    /**
     * Validate all of the merge data for a given recipient
     * @param array $recipients
     * @returns boolean
     */
    private static function validateMergeData($recipients)
    {
        $recipientsWithInvalidMergeData = SendValidator::getRecipientsWithInvalidMergeData($recipients);

        if (count($recipientsWithInvalidMergeData) > 0) {
            $sendResponse = new \Socketlabs\SendResponse(\Socketlabs\SendResult::InvalidMergeData);
            $sendResponse->addressResults = $recipientsWithInvalidMergeData;
            return $sendResponse;
        }

        return new \Socketlabs\SendResponse(\Socketlabs\SendResult::Success);
    }

    /**
     * Helper function to remove case insensitive duplicates from an array of strings
     * @param array $array
     * @return array
     */
    private static function array_iunique($array)
    {
        return array_intersect_key(
            $array,
            array_unique(array_map("StrToLower", $array))
        );
    }

    /**
     * Helper function to determine if a string is empty.
     * @param string $value
     * @return boolean
     */
    private static function not_empty($value)
    {
        return is_string($value) && !ctype_space($value) && $value != "";
    }
}
