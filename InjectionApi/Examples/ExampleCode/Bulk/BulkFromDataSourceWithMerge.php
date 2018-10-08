<?php
include_once (__DIR__ . "../../includes.php");
include_once (__DIR__ . "../../DataSource\Customer.php");
include_once (__DIR__ . "../../DataSource\CustomerRepository.php");
 
use Socketlabs\Message\BulkRecipient;
use Socketlabs\Message\EmailAddress;  
use Socketlabs\Message\BulkMessage;
use Socketlabs\SocketLabsClient;

$client = new SocketLabsClient(exampleConfig::serverId(), exampleConfig::password());

//Build the message
$message = new BulkMessage();

$message->subject = "Hello %%FirstName%%";
$message->from = new EmailAddress("from@example.com");
$message->ReplyTo = new EmailAddress("replyto@example.com");

$message->htmlBody = "<html>" .
                        "<head><title>Data Source Merge Data Example</title></head>" .
                        "<body>" .
                            "<h1>Sending A Test Message With Merge Data From Datasource</h1>" .
                            "<h2>Hello %%FirstName%% %%LastName%%.</h2>" .
                            "<p>Is your favorite color still %%FavoriteColor%%?</p>" .
                        "</body>" .
                     "</html>";

$message->plainTextBody = "Sending A Test Message With Merge Data From Datasource" . 
                          "       Hello %%FirstName%% %%LastName%%. Is your favorite color still %%FavoriteColor%%?";

// Retrieve data from the datasource
$repo = new CustomerRepository();
$customers = $repo->GetData();

// Merge in the customers from the datasource
foreach($customers as $customer){

    $recipient = new BulkRecipient($customer->email);
    
    $recipient->addMergeData("FirstName", $customer->firstName);
    $recipient->addMergeData("LastName", $customer->lastName);
    $recipient->addMergeData("FavoriteColor", $customer->favoriteColor);

    $message->addToAddress($recipient);
}


$response = $client->send($message);