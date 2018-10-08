<?php
include_once (__DIR__ . "../../includes.php");

use Socketlabs\Message\BulkMessage;
use Socketlabs\Message\BulkRecipient;
use Socketlabs\SocketLabsClient;

$client = new SocketLabsClient(exampleConfig::serverId(), exampleConfig::password()); 
 
//Build the message
$message = new BulkMessage();
$message->subject = "Sending A Test Message";
$message->from = new BulkRecipient("from@example.com");

//Set the content to use MergeData
$message->htmlBody = "<html>" .
                     "<head><title>ASCII Merge Data Example</title></head>" .
                     "<body>" .
                        "<h1>Merge Data</h1>" .
                        "<p>Complete? = %%Complete%%</p>" .
                     "</body>" .
                     "</html>";
$message->plainTextBody = "Merge Data     Complete? = %%Complete%%";

//Set the character set
$message->charset = "ASCII";

//Create recipients with MergeData that uses the character set (✔, ✘)
$recipient1 = new BulkRecipient("recipient1@example.com", "Recipient #1");
$recipient1->addMergeData("Complete", "✔");

$recipient2 = new BulkRecipient("recipient2@example.com", "Recipient #2"); 
$recipient2->addMergeData("Complete", "✔");

$recipient3 = new BulkRecipient("recipient3@example.com"); 
$recipient3->addMergeData("Complete", "✘");

//Add the recipients to the message
$message->addToAddress($recipient1);
$message->addToAddress($recipient2);
$message->addToAddress($recipient3);
    
//Create the client and send the message

$response = $client->send($message);