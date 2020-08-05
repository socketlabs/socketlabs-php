<?php 
include_once (__DIR__ . "../../includes.php");

use Socketlabs\Message\BulkMessage;
use Socketlabs\Message\BulkRecipient;
use Socketlabs\SocketLabsClient;

$client = new SocketLabsClient(exampleConfig::serverId(), exampleConfig::password()); 

//Build the message
$message = new BulkMessage();

$message->subject = "Sending A Bulk Message with ampBody";
$message->htmlBody = "<html>This is the Html Body of my message.</html>";
$message->ampBody = "<!doctype html>" +
"<html amp4email>" +
"<head>" +
"  <meta charset=\"utf-8\">" +
"  <script async src=\"https://cdn.ampproject.org/v0.js\"></script>" +
"  <style amp4email-boilerplate>body{visibility:hidden}</style>" +
"  <style amp-custom>" +
"    h1 {" +
"      margin: 1rem;" +
"    }" +
"  </style>" +
"</head>" +
"<body>" +
"  <h1>This is the AMP Html Body of the message</h1>" +
"</body>" +
"</html>";
$message->from = new BulkRecipient("from@example.com");
$message->replyTo = new BulkRecipient("replyto@example.com");

//Add Bulk Recipients
$message->addToAddress (new BulkRecipient("recipient1@example.com", "Recipient #1"));
$message->addToAddress (new BulkRecipient("recipient2@example.com", "Recipient #2"));
$message->addToAddress (new BulkRecipient("recipient3@example.com", "Recipient #3"));
$message->addToAddress (new BulkRecipient("recipient4@example.com", "Recipient #4"));
 
$response = $client->send($message);
