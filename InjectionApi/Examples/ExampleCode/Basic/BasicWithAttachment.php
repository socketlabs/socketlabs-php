<?php
include_once (__DIR__ . "../../includes.php");

use Socketlabs\Message\BasicMessage;
use Socketlabs\Message\EmailAddress;
use Socketlabs\SocketLabsClient; 

$client = new SocketLabsClient(exampleConfig::serverId(), exampleConfig::password()); 

//Build the message
$message = new BasicMessage(); 

$message->subject = "Sending A Test Message";
$message->htmlBody = "<html>This is the Html Body of my message.</html>";
$message->plainTextBody = "This is the Plain Text Body of my message.";
$message->from = new EmailAddress("from@example.com");
$message->addToAddress(new EmailAddress("recipient1@example.com", "Recipient #1"));

//Add attachment (with optional headers if desired)
$att = \Socketlabs\Message\Attachment::createFromPath( __DIR__ . "/../Img/Bus.png", "Bus.png", "IMAGE/PNG", "Bus");
$att->customHeaders = array(
    "Color" => "Orange",
    "Place" => "Beach",
);
$message->attachments[] = $att;
 
$response = $client->send($message);