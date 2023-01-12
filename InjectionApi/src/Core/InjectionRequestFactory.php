<?php

namespace Socketlabs\Core;

/**
 * Used by the Send function of the SocketLabsClient to generate an InjectionRequest for the Injection Api
 */
class InjectionRequestFactory
{

    private $serverId;
    private $apiKey;

    /**
     * Creates a new instance of the InjectionRequestFactory.
     * @param number $serverId
     * @param string $apiKey
     */
    public function __construct($serverId, $apiKey)
    {
        $this->serverId = $serverId;
        $this->apiKey = $apiKey;
    }

    /**
     * Generate request setting properties.
     * @param object $message
     * @return object
     */
    public function generateRequest($message)
    {

        if (is_a($message, "Socketlabs\Message\BulkMessage")) {
            return $this->generateBulkRequest($message);
        }
        return $this->generateBasicRequest($message);
    }

    /**
     * Generate request setting properties common to both message types.
     * @param object $message
     * @return object
     */
    private function generateRequestCore($message)
    {

        $request = new InjectionRequest($this->serverId, $this->apiKey);

        $messageJson = new \Socketlabs\Core\Serialization\MessageJson();
        $messageJson->Subject = $message->subject;
        $messageJson->TextBody = $message->plainTextBody;
        $messageJson->HtmlBody = $message->htmlBody;
        $messageJson->MailingId = $message->mailingId;
        $messageJson->MessageId = $message->messageId;
        $messageJson->CharSet = $message->charset;
        $messageJson->ApiTemplate = $message->apiTemplate;

        //set attachments
        $messageJson->Attachments = $this->getAttachments($message->attachments);

        //set custom headers
        $messageJson->CustomHeaders = $this->getCustomHeaders($message->customHeaders);

        //set from address
        $messageJson->From = new \Socketlabs\Core\Serialization\AddressJson($message->from->emailAddress, $message->from->friendlyName);

        //reply-to is optional, if provided, set it
        if ($message->replyTo != null)
            $messageJson->ReplyTo = new \Socketlabs\Core\Serialization\AddressJson($message->replyTo->emailAddress, $message->replyTo->friendlyName);

        //append message to messages collection. there should only be one
        $request->Messages[] = $messageJson;

        return $request;
    }

    /**
     * Generate request representing a basic message
     * @param BasicMessage $basicMessage
     * @return object
     */
    private function generateBasicRequest($basicMessage)
    {

        //populate properties common to all messages
        $request = $this->generateRequestCore($basicMessage);
        $messageJson = $request->Messages[0];

        //populate To, Cc, Bcc collections
        $messageJson->To = $this->getAddressList($basicMessage->to);
        $messageJson->Cc = $this->getAddressList($basicMessage->cc);
        $messageJson->Bcc = $this->getAddressList($basicMessage->bcc);

        //this is important. if PerMessage is set, the api will process this as a bulk style message.
        //$messageJson->MergeData->PerMessage = null;
        unset($messageJson->MergeData);

        return $request;
    }

    /**
     * Generate request representing a bulk message
     * @param object $bulkMessage
     * @return object
     */
    private function generateBulkRequest($bulkMessage)
    {

        //populate properties common to all messages
        $request = $this->generateRequestCore($bulkMessage);
        $messageJson = $request->Messages[0];

        //magic recipient & friendly name used when sending bulk style
        $messageJson->To = array(new \Socketlabs\Core\Serialization\AddressJson("%%DeliveryAddress%%", "%%Recipient Name%%"));

        //recipients and merge fields are all sent as merge data
        $messageJson->MergeData->PerMessage = $this->getBulkMergeFields($bulkMessage->to);

        //Add global merge data. This is used only in bulk-style messages
        $messageJson->MergeData->Global = $this->getGlobalMergeFields($bulkMessage->global);

        return $request;
    }


    /**
     * Shapes list of email addresses into injection api format
     * @param EmailAddress $emailAddress
     * @return object
     */
    private function getAddressList($emailAddresses)
    {

        if ($emailAddresses == null)
            return null;

        $results = array();

        foreach ($emailAddresses as $emailAddress) {
            $results[] = new \Socketlabs\Core\Serialization\AddressJson($emailAddress->emailAddress, $emailAddress->friendlyName);
        }
        return $results;
    }

    /**
     * Helper function to map array of Attachmets to array of AttachmentsJson
     * @param array $attachment
     * @return array
     */
    private function getAttachments($attachments)
    {
        if ($attachments == null)
            return null;

        $results = array();

        foreach ($attachments as $attachment) {

            $target = new \Socketlabs\Core\Serialization\AttachmentJson();
            $target->Name = $attachment->name;
            $target->ContentType = $attachment->mimeType;
            $target->ContentId = $attachment->contentId;
            $target->Content = base64_encode($attachment->content);

            //map custom headers
            $target->CustomHeaders = $this->getCustomHeaders($attachment->customHeaders);

            $results[] = $target;
        }

        return $results;
    }

    /**
     * Helper function to map array of CustomHeader to CustomHeaderJson
     * @param array $customHeader
     * @return array
     */
    private function getCustomHeaders($customHeaders)
    {
        if ($customHeaders == null) return null;

        $results = array();

        while ($customHeader = current($customHeaders)) {
            if (is_a($customHeader, "CustomHeader")) {
                $results[] = new \Socketlabs\Core\Serialization\CustomHeadersJson($customHeader->name, $customHeader->value);
            } else {
                $key = key($customHeaders);
                $results[] = new \Socketlabs\Core\Serialization\CustomHeadersJson($key, $customHeader);
            }
            next($customHeaders);
        }

        return $results;
    }

    /**
     * Shape bulk recipients and their merge data into the format needed for the injection api
     * @param object $bulkRecipients
     * @return array
     */
    private function getBulkMergeFields($bulkRecipients)
    {

        $allRecipients = array();

        //loop through each recipient
        foreach ($bulkRecipients as $bulkRecipient) {

            //add address
            $recipientMergeFields = array();
            $recipientMergeFields[] = new \Socketlabs\Core\Serialization\MergeFieldJson("DeliveryAddress", $bulkRecipient->emailAddress);

            //add friendly name if provided
            if ($bulkRecipient->friendlyName != null)
                $recipientMergeFields[] = new \Socketlabs\Core\Serialization\MergeFieldJson('RecipientName', $bulkRecipient->friendlyName);


            //if merge fields provided, add them as well
            if ($bulkRecipient->mergeData != null) {
                foreach ($bulkRecipient->mergeData as $mergeData) {
                    $recipientMergeFields[] = new \Socketlabs\Core\Serialization\MergeFieldJson($mergeData->Name, $mergeData->Value);
                }
            }

            //add recipient merge data to the results
            array_push($allRecipients, $recipientMergeFields);
        }
        return $allRecipients;
    }

    /**
     * Shape global merge fields into format needed for the injection api
     * @param object $globalMergeData merge data array
     * @return array
     */
    private function getGlobalMergeFields($globalMergeData)
    {

        if ($globalMergeData == null)
            return null;

        $results = array();

        foreach ($globalMergeData as $mergeData) {
            $results[] = new \Socketlabs\Core\Serialization\MergeFieldJson($mergeData->Name, $mergeData->Value);
        }
        return $results;
    }
}
