<?php
include_once(__DIR__ . "../../includes.php");

use Socketlabs\Message\BasicMessage;
use Socketlabs\Message\EmailAddress;
use Socketlabs\SocketLabsClient;

$client = new SocketLabsClient(exampleConfig::serverId(), exampleConfig::password());

//Build the message
$message = new BasicMessage();

$message->subject = "Sending An Email With Custom Headers";
$message->htmlBody = "<body><strong>Lorem Ipsum</strong></body>";
$message->plainTextBody = "Lorem Ipsum";
$message->from = new EmailAddress("from@example.com");
$message->addToAddress(new EmailAddress("recipient1@example.com", "Recipient #1"));

//Add custom headers to the message
//There are serveral ways to add custom fields to a message
$message->addCustomHeader("My-Header", "1...2...3...");
$message->addCustomHeader("Example-Type", "BasicWithCustomHeaders");

//OR
$message->customHeaders[] =  new \Socketlabs\Message\CustomHeader("My-Header", "1...2...3...");
$message->customHeaders[] =  new \Socketlabs\Message\CustomHeader("Example-Type", "BasicWithCustomHeaders");

//OR
$message->customHeaders = array(
    "My-Header" => "1...2...3...",
    "Example-Type" => "BasicWithCustomHeaders",
);


//Create the client and send the message
$response = $client->send($message);
