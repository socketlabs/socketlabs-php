<?php 
include_once (__DIR__ . "../../includes.php");

use Socketlabs\Message\BasicMessage;
use Socketlabs\Message\EmailAddress;
use Socketlabs\Message\Attachment;
use Socketlabs\SocketLabsClient;
 
$client = new SocketLabsClient(exampleConfig::serverId(), exampleConfig::password());

//Build the message
$message = new BasicMessage();

$message->subject = "Sending an Email With An Embedded Image";
$message->plainTextBody = "Lorem Ipsum";
$message->from = new EmailAddress("from@example.com"); 
$message->addToAddress(new EmailAddress("recipient1@example.com", "Recipient #1"));
 
//Add an image attachment 
$message->attachments[] = Attachment::createFromPath( __DIR__."/../Img/Bus.png", "Bus.png", "IMAGE/PNG", "Bus");

//Display the attachment in the html body
$message->htmlBody = "<body><p><strong>Lorem Ipsum</strong></p><br /><img src=\"cid:Bus\" /></body>";

$response = $client->send($message);