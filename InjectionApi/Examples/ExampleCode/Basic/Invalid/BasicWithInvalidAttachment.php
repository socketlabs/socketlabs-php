<?php 
include_once (__DIR__ . "../../../includes.php");

use Socketlabs\Message\BasicMessage;
use Socketlabs\Message\EmailAddress;
use Socketlabs\Message\Attachment;
use Socketlabs\SocketLabsClient;

$client = new SocketLabsClient(exampleConfig::serverId(), exampleConfig::password()); 
 
//Build the message
$message = new BasicMessage(); 

$message->subject = "Sending A Test Message";
$message->htmlBody = "<html>This is the Html Body of my message.</html>";
$message->plainTextBody = "This is the Plain Text Body of my message.";
$message->from = new EmailAddress("from@example.com");
$message->addToAddress(new EmailAddress("recipient1@example.com"));

//Invalid attachment (empty stream)
$stream = fopen('data://text/plain;base64,' . base64_encode(""),'r');
$message->attachments[] = Attachment::createFromStream($stream, "Bus.png", "IMAGE/PNG", "Bus"); 
 
//Send message
$response = $client->send($message);