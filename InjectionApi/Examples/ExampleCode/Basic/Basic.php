<?php
include_once (__DIR__ . "../../includes.php");

use Socketlabs\SocketLabsClient;
use Socketlabs\Message\BasicMessage;
use Socketlabs\Message\EmailAddress;
 
$client = new SocketLabsClient(exampleConfig::serverId(), exampleConfig::password()); 
 
$message = new BasicMessage(); 

$message->subject = "Sending A Basic Message";
$message->htmlBody = "<html>This is the Html Body of my message.</html>";
$message->plainTextBody = "This is the Plain Text Body of my message.";

$message->from = new EmailAddress("from@example.com");
$message->replyTo = new EmailAddress("replyto@example.com");

//A basic message supports up to 50 recipients and supports several different ways to add recipients
$message->addToAddress("recipient1@example.com"); //Add a To address by passing the email address
$message->addCcAddress("recipient2@example.com", "Recipient #2"); //Add a CC address by passing the email address and a friendly name
$message->addBccAddress(new EmailAddress("recipient3@example.com")); //Add a BCC address by passing an EmailAddress object
 
$response = $client->send($message);
