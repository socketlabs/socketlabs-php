<?php 
include_once (__DIR__ . "../../includes.php");

use Socketlabs\Message\BulkMessage;
use Socketlabs\Message\BulkRecipient;
use Socketlabs\Message\EmailAddress;
use Socketlabs\Message\CustomHeader;
use Socketlabs\Message\Attachment;
use Socketlabs\SocketLabsClient;

$client = new SocketLabsClient(exampleConfig::serverId(), exampleConfig::password());   
 
//Build the message
$message = new BulkMessage();

//Add some global merge-data (These will be applied to all Recipients unless specifically overridden by Recipient level merge-data)
$message->addGlobalMergeData("Motto", "When hitting the Inbox matters!");
$message->addGlobalMergeData("Birthday", "Unknown");
$message->addGlobalMergeData("Age", "an unknown number of");
$message->addGlobalMergeData("UpSell", "BTW:  You are eligible for discount pricing when you upgrade your service!");

//Add recipients with merge data
$recipient1 = new BulkRecipient("recipient1@example.com");
$recipient1->addMergeData("Birthday", "08/05/1991");
$recipient1->addMergeData("Age", "27");
$message->addToAddress($recipient1);

$recipient2 = new BulkRecipient("recipient2@example.com"); 
$recipient2->addMergeData("Birthday", "04/12/1984");
$recipient2->addMergeData("Age", "34");
$recipient2->addMergeData("UpSell", "");    // This will override the Global Merge-Data for this specific Recipient
$message->addToAddress($recipient2);

$recipient3 = new BulkRecipient("recipient3@example.com", "Recipient 3");   // The merge-data for this Recipient will be populated with Global Merge-Data
$message->addToAddress($recipient3);

//Set other properties as needed
$message->subject = "Complex BulkSend Example";
$message->from = new EmailAddress("from@example.com", "FromMe");
$message->replyTo =  new EmailAddress("replyto@example.com");

//Apply Custom Headers to the message
$message->customHeaders[] = new CustomHeader("testMessageHeader", "I am a message header");

//Build the Content (Note the %% symbols used to denote the data to be merged)
$message->htmlBody = "<html>" . 
                     "<head><title>Complex</title></head>" . 
                        "<body>" . 
                            "<h1>Merged Data</h1>" . 
                            "<p>" . 
                                "Motto = <b>%%Motto%%</b> </br>" . 
                                "Birthday = <b>%%Birthday%%</b> </br>" . 
                                "Age = <b>%%Age%%</b> </br>" . 
                                "UpSell = <b>%%UpSell%%</b> </br>" . 
                            "</p>" . 
                            "</br>" . 
                            "<h1>Example of Merge Usage</h1>" . 
                            "<p>" . 
                                "Our company motto is '<b>%%Motto%%</b>'. </br>" . 
                                "Your birthday is <b>%%Birthday%%</b> and you are <b>%%Age%%</b> years old. </br>" . 
                                "</br>" . 
                                "<b>%%UpSell%%<b>" . 
                            "</p>" . 
                        "</body>" . 
                     "</html>";

$message->plainTextBody = "Global Merge Data" .
                     "CompanyMotto = %%Motto%%" .
                     "     " .
                      "Per Recipient Merge Data" .
                     "     EyeColor = %%EyeColor%%" .
                     "     HairColor = %%HairColor%%";

//Add an attachment (with a Custom Header)
$att = Attachment::createFromPath( __DIR__ . "/../Img/Bus.png", "Bus.png", "IMAGE/PNG", "Bus");
$att->customHeaders = array("Attachment-Header" => "I Am A Bus");
$message->attachments[] = $att;
 
$response = $client->send($message);