<?php
namespace Socketlabs\Core;

class RetryHandler{
    
    private $httpClient;
    private $endpointUrl;
    private $retrySettings;

    const ERROR_CODES = array(500, 502, 503, 504);

    public function __construct($httpClient, $endpointUrl, $retrySettings){

        $this->httpClient = $httpClient;
        $this->endpointUrl = $endpointUrl;
        $this->retrySettings = $retrySettings;

    }

    public function send(){

        if ($this->retrySettings->getMaximumNumberOfRetries() == 0;){

            $context = stream_context_create($this->httpClient);
            $response = file_get_contents($this->endpointUrl, FALSE, $context);
            return $response;

        }

        $attempts = 0

        do{
            $waitInterval = $this->retrySettings->getNextWaitInterval($attempts);

            try {
                
                $context = stream_context_create($this->httpClient);
                $response = file_get_contents($this->endpointUrl, FALSE, $context);
                
            } catch (Exception $e) {
                $attempts++;

            }

        } while(TRUE);
    }

}
