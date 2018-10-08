<?php
include_once (__DIR__ . "../../../includes.php");

use Socketlabs\Message\BasicMessage;
use Socketlabs\Message\EmailAddress;
use Socketlabs\SocketLabsClient; 
 
$client = new SocketLabsClient(exampleConfig::serverId(), exampleConfig::password()); 
 
//Build the message
$message = new BasicMessage();

$message->subject = "Sending A Test Message";
$message->htmlBody = "<html>This is the Html Body of my message.</html>";
$message->plainTextBody = "This is the Plain Text Body of my message.";
$message->addToAddress(new EmailAddress("recipient1@example.com"));

//Invalid email address
$message->from = new EmailAddress("!@#$!@#$!@#$@#!$");


$response = $client->send($message);