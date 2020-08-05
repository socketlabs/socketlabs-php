<?php
include_once (__DIR__ . "../../includes.php");

use Socketlabs\Message\BasicMessage;
use Socketlabs\Message\EmailAddress;
use Socketlabs\SocketLabsClient;

$client = new SocketLabsClient(exampleConfig::serverId(), exampleConfig::password()); 
 
//Build the message
$message = new BasicMessage();

$message->subject = "Sending a Message with ampBody support";
$message->from = new EmailAddress("from@example.com");
$message->addToAddress(new EmailAddress("recipient1@example.com", "Recipient #1"));

//Pass in the ID of the template to use as the htmlBody
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
"  <h1>This is the AMP Html Body of my message</h1>" +
"</body>" +
"</html>";
 
$response = $client->send($message);
