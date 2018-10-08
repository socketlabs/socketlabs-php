<?php
include_once (__DIR__ . "../../../includes.php");

use Socketlabs\Message\EmailAddress;
use Socketlabs\Message\BasicMessage;
use Socketlabs\SocketLabsClient;

$client = new SocketLabsClient(exampleConfig::serverId(), exampleConfig::password()); 
 
//Build the message
$message = new BasicMessage();

$message->subject = "Sending A Test Message";
$message->htmlBody = "<html>This is the Html Body of my message.</html>";
$message->plainTextBody = "This is the Plain Text Body of my message.";
$message->from = new EmailAddress("from@example.com"); 

//Valid
$message->addToAddress(new EmailAddress("this@works"));             
$message->addToAddress(new EmailAddress("recipient@example.com")); 

 //Invalid
$message->addToAddress(new EmailAddress("!@#$!@#$!@#$@#!$"));      
$message->addToAddress(new EmailAddress("failure.com"));
$message->addToAddress(new EmailAddress("ImMissingSomethin"));
$message->addToAddress(new EmailAddress("Fail@@!.Me"));


$response = $client->send($message);