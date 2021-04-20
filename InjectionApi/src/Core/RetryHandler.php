<?php
namespace Socketlabs\Core;

class RetryHandler{
    
    private $httpClient;
    private $endpointUrl;
    private $retrySettings;

    const ERROR_CODES = array(500, 502, 503, 504);

    public function __construct($client, $endpointurl, $settings){

        $this->httpClient = $client;
        $this->endpointUrl = $endpointurl;
        $this->retrySettings = $settings;

    }

    public function send(){

        if ($this->retrySettings->getMaximumNumberOfRetries() == 0){

            $context = stream_context_create($this->httpClient);
            $response = file_get_contents($this->endpointUrl, FALSE, $context);
            return array($response, $http_response_header);

        }

        $attempts = 0;

        do {

            $waitInterval = (int)$this->retrySettings->getNextWaitInterval($attempts)/1000;
 
            $context = stream_context_create($this->httpClient);
            $response = file_get_contents($this->endpointUrl, FALSE, $context);

            if (($attempts < $this->retrySettings->getMaximumNumberOfRetries()) && (($response === FALSE && !isset($http_response_header)) || (in_array(intval(explode(" ", $http_response_header[0])[1]), self::ERROR_CODES)))){
                
                $attempts++;
                sleep($waitInterval);
            }
            else{
                return array($response, $http_response_header);
            } 

        } while(TRUE);
    }

}
