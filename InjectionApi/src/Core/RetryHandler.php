<?php
namespace Socketlabs\Core;

class RetryHandler{
    
    private $httpClient;
    private $endpointUrl;
    private $retrySettings;

    const ERROR_CODES = array(500, 502, 503, 504);

    public function __construct($client, $endpointurl, $settings){

        $log = fopen('d:\\log.txt', 'a') or die("unable to open file");
        fwrite($log, "In Retry Handler Constructor\n");
        fclose($log);

        $this->httpClient = $client;
        $this->endpointUrl = $endpointurl;
        $this->retrySettings = $settings;

    }

    public function send(){

        if ($this->retrySettings->getMaximumNumberOfRetries() == 0){

            $log = fopen('d:\\log.txt', 'a') or die("unable to open file");
            fwrite($log, "Send With No Retry \n");
            fclose($log);

            $context = stream_context_create($this->httpClient);
            $response = file_get_contents($this->endpointUrl, FALSE, $context);
            return array($response, $http_response_header);

        }

        $attempts = 0;

        $log = fopen('d:\\log.txt', 'a') or die("unable to open file");
        fwrite($log, "Send With a Retry \n");
        fclose($log);

        do {

            $log = fopen('d:\\log.txt', 'a') or die("unable to open file");
            fwrite($log, "In Do While Loop \n");
            fclose($log);

            $waitInterval = (int)$this->retrySettings->getNextWaitInterval($attempts)/1000;
            
            $log = fopen('d:\\log.txt', 'a') or die("unable to open file");
            fwrite($log, "In Loop : ".$waitInterval." \n");
            fclose($log);
 
            $context = stream_context_create($this->httpClient);
            $response = file_get_contents($this->endpointUrl, FALSE, $context);

            $log = fopen('d:\\log.txt', 'a') or die("unable to open file");
            if(in_array(intval(explode(" ", $http_response_header[0])[1]), self::ERROR_CODES)){

                fwrite($log, "Status Code : ".intval(explode(" ", $http_response_header[0])[1])." \n");

            }

            if($response === FALSE && !isset($http_response_header)){

                fwrite($log, "Time Out \n");

            }
            
            fclose($log);

            if (($attempts < $this->retrySettings->getMaximumNumberOfRetries()) && (($response === FALSE && !isset($http_response_header)) || (in_array(intval(explode(" ", $http_response_header[0])[1]), self::ERROR_CODES)))){
                
                $attempts++;
                
                $log = fopen('d:\\log.txt', 'a') or die("unable to open file");
                fwrite($log, "Retry : ".$attempts." \n");
                fclose($log);
                sleep($waitInterval);
            }
            else{
                return array($response, $http_response_header);
            } 

        } while(TRUE);
    }

}
