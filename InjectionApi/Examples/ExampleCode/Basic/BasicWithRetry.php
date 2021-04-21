<?php
include_once (__DIR__ . "../../includes.php");

use Socketlabs\Message\BasicMessage;
use Socketlabs\Message\EmailAddress;
use Socketlabs\SocketLabsClient;

$client = new SocketLabsClient(exampleConfig::serverId(), exampleConfig::password());
$client->proxyUrl = exampleConfig::proxy(); 
$client->requestTimeout = 5;
$client->numberOfRetries = 2;


 
//Build the message
$message = new BasicMessage(); 

$message->subject = "Sending A Test Message With Retry";
$message->htmlBody = "<html>This is the Html Body of my message.</html>";
$message->plainTextBody = "This is the Plain Text Body of my message.";
$message->from = new EmailAddress("from@example.com");
$message->addToAddress(new EmailAddress("recipient1@example.com", "Recipient #1"));
 
//Send the message
$response = $client->send($message);