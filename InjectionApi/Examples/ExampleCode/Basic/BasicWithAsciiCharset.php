<?php 
include_once (__DIR__ . "../../includes.php");

use Socketlabs\Message\BasicMessage;
use Socketlabs\Message\EmailAddress;
use Socketlabs\SocketLabsClient;

$client = new SocketLabsClient(exampleConfig::serverId(), exampleConfig::password()); 

//Build the message
$message = new BasicMessage();

$message->subject = "Sending An ASCII Charset Email";
$message->from = new EmailAddress("from@example.com");
$message->addToAddress(new EmailAddress("recipient1@example.com", "Recipient #1"));
$message->plainTextBody = "Lorem Ipsum";

//Set the character set
$message->charset = "ASCII";

//Use the character set (✔)
$message->htmlBody = "<body><strong>Lorem Ipsum</strong>Unicode: ✔ - Check</body>"; 

$response = $client->send($message);