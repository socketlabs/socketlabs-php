<?php
namespace Socketlabs;

/**
 * SocketLabsClient is a wrapper for the SocketLabs Injection API that makes
 * it easy to send messages and parse responses.
 * Example:
 *      $client = new SocketLabsClient(00000, "apiKey");
 *       $message = new BasicMessage();
 *      //Build Message Here
 *      $response = client.Send(message);
 *      if (response.Result != SendResult.Success)
 *      {
 *          // Handle Error
 *      }
 */
class SocketLabsClient{

        private $serverId;
        private $apiKey;

        const VERSION = "1.2.2";
        public $version = self::VERSION;

        /**
         * Configure to different endpoint if the need arises
         */
        public $endpointUrl;

        /**
         * Configure proxy such as fiddler if desired
         */
        public $proxyUrl;

        /**
         * Configure to different timeout if desired
         */
        public $requestTimeout;

        /**
         * Configure to different timeout if desired
         */
        public $numberOfRetries;

        /**
         * Creates a new instance of the SocketLabsClient.
         */
        public function __construct($serverId, $apiKey){
                $this->serverId = $serverId;
                $this->apiKey = $apiKey;
                $this->endpointUrl = "https://inject.socketlabs.com/api/v1/email";
                $this->requestTimeout = 120;
                $this->numberOfRetries = 0;
                $this::setUserAgent();
        }

        /**
         * Sends a basic/bulk email message and returns the response from the Injection API.
         * @return SendResponse
         */
        public function send($message){

                $validationResult = Core\SendValidator::validateCredentials($this->serverId, $this->apiKey);
                if($validationResult->result != \Socketlabs\SendResult::Success) return $validationResult;

                $validationResult = Core\SendValidator::validateMessage($message);
                if($validationResult->result != \Socketlabs\SendResult::Success) return $validationResult;

                $factory = new Core\InjectionRequestFactory($this->serverId, $this->apiKey);
                $newRequest = $factory->generateRequest($message);

                $options = $this->createStreamOptions($newRequest);

                $retrySettings = new RetrySettings($this->numberOfRetries);
                $retryHandler = new Core\RetryHandler($options, $this->endpointUrl, $retrySettings);
                list($response, $responseHeader) = $retryHandler->send();

                return Core\InjectionResponseParser::parse($response, $responseHeader);
        }

        /**
         * Helper function to set the user agent
         */
        private function setUserAgent(){

                $phpVersion = phpversion();
                $userAgent = "SocketLabs-php/$this->version(php $phpVersion)";

                ini_set("user_agent", $userAgent);
        }

        /**
         * Helper function to create the stream options
         * @param $injectionRequest
         */
        private function createStreamOptions($injectionRequest){
             $http = array(
                'method' => 'POST',
                'header' => 'Content-type: application/json',
                'content' => json_encode($injectionRequest),
                'timeout' => $this->requestTimeout
             );

             //proxy not enabled, return these simple options
             if($this->proxyUrl == null){
                return array('http' => $http);
             }

                //shape proxy url to use 'tcp'
                $tcpUrl = str_replace('https', 'tcp', $this->proxyUrl);
                $tcpUrl = str_replace('http', 'tcp', $tcpUrl);
                //set proxy
                $http += ['proxy' => $tcpUrl];

             //include ssl options
             return array(
                    "http" => $http
                    // If you are having trouble configuring a proxy tool such as fiddler, this can be a quick fix,
                    // but it is not recommended for production. The best way is to configure the appropriate certificate
                    // authority property in your php.ini, for example: 'openssl.cafile'

                    //Proxy Quick Fix:
                    //,
                    //"ssl"=> array(
                    //        "verify_peer"=>false,
                    //        "verify_peer_name"=>false,
                    //)
             );
        }
}
