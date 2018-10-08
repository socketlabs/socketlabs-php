<?php 
include_once (__DIR__ . "../../includes.php");

use Socketlabs\Message\BulkMessage;
use Socketlabs\Message\EmailAddress;
use Socketlabs\Message\BulkRecipient;
use Socketlabs\SocketLabsClient;

$client = new SocketLabsClient(exampleConfig::serverId(), exampleConfig::password());   

//Build the message
$message = new BulkMessage();
$message->subject = "Sending A BulkSend with MergeData";
$message->from = new EmailAddress("from@example.com");

//Build the Content (Note the %% symbols used to denote the data to be merged)
$message->htmlBody = "<html>" . 
                     "<head><title>Merge Data Example</title></head>" . 
                     "<body>" . 
                        "<h1>Global Merge Data</h1>" .
                        "<p>CompanyMotto = %%Motto%%</p>" .
                        "<h1>Per Recipient Merge Data</h1>" .
                        "<p>EyeColor = %%EyeColor%%</p>" .
                        "<p>HairColor = %%HairColor%%</p>" .
                     "</body>" . 
                     "</html>";

$message->plainTextBody = "Global Merge Data " .
                     "CompanyMotto = %%Motto%%" .
                     "     " .
                     "Per Recipient Merge Data" .
                     "     EyeColor = %%EyeColor%%" .
                     "     HairColor = %%HairColor%%";

//Add some global merge data
$message->addGlobalMergeData("Motto", "When hitting the Inbox matters!");

//Add recipients with merge data
$recipient1 = new BulkRecipient("recipient1@example.com", "Recipient #1");
$recipient1->addMergeData("EyeColor", "Blue");
$recipient1->addMergeData("HairColor", "Blond");

$recipient2 = new BulkRecipient("recipient2@example.com", "Recipient #2"); 
$recipient1->addMergeData("EyeColor", "Green");
$recipient1->addMergeData("HairColor", "Brown");

$recipient3 = new BulkRecipient("recipient3@example.com", "Recipient #3"); 
$recipient1->addMergeData("EyeColor", "Hazel");
$recipient1->addMergeData("HairColor", "Black");

//Add the recipients to the message
$message->addToAddress($recipient1);
$message->addToAddress($recipient2);
$message->addToAddress($recipient3);

//Create the client and send the message 
$response = $client->send($message);