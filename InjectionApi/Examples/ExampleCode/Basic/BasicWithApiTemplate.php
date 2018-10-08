<?php
include_once (__DIR__ . "../../includes.php");

use Socketlabs\Message\BasicMessage;
use Socketlabs\Message\EmailAddress;
use Socketlabs\SocketLabsClient; 

$client = new SocketLabsClient(exampleConfig::serverId(), exampleConfig::password()); 
 
//Build the message
$message = new BasicMessage();

$message->subject = "Sending Using a Template";
$message->from = new EmailAddress("from@example.com");
$message->addToAddress(new EmailAddress("recipient1@example.com", "Recipient #1"));

//Pass in the ID of the template to use as the htmlBody
$message->apiTemplate = 1;
 
$response = $client->send($message);