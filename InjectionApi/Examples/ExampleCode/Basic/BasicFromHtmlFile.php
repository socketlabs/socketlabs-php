<?php 
include_once (__DIR__ . "../../includes.php");

use Socketlabs\Message\BasicMessage;
use Socketlabs\Message\EmailAddress;
use Socketlabs\SocketLabsClient;
 
$client = new SocketLabsClient(exampleConfig::serverId(), exampleConfig::password()); 

//Build the message
$message = new BasicMessage(); 

$message->subject = "Simple Html file with text";
$message->plainTextBody = "This is the Plain Text Body of my message.";
$message->from = new EmailAddress("from@example.com");
$message->addToAddress(new EmailAddress("recipient1@example.com", "Recipient #1"));

//Get html content from a file
$pathToHtmlFile = __DIR__ .'../../../ExampleCode/Html/SampleEmail.html'; 
$message->htmlBody = file_get_contents($pathToHtmlFile);
 
//Send the message
$response = $client->send($message);
