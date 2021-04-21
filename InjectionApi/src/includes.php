<?php 
if(! defined('SOCKETLABS_INJECTION_API_ROOT_PATH')) define('SOCKETLABS_INJECTION_API_ROOT_PATH', dirname(__DIR__));

include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/Core/InjectionRequest.php");
include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/Core/RetryHandler.php");
include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/Core/InjectionRequestFactory.php");
include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/Core/InjectionResponseParser.php");
include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/Core/SendValidator.php");

include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/Core/Serialization/AddressJson.php");
include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/Core/Serialization/CustomHeadersJson.php");
include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/Core/Serialization/MergeDataJson.php");
include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/Core/Serialization/MergeFieldJson.php");
include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/Core/Serialization/MessageJson.php");

include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/Message/Attachment.php");
include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/Message/CustomHeader.php");
include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/Message/BaseMessage.php");
include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/Message/BasicMessage.php");
include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/Message/BulkMessage.php");
include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/Message/EmailAddress.php");
include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/Message/BulkRecipient.php");

include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/AddressResult.php");
include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/RetrySettings.php");
include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/SendResponse.php");
include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/SendResult.php");
include_once (SOCKETLABS_INJECTION_API_ROOT_PATH."/src/SocketLabsClient.php");

