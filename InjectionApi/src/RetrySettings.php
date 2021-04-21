<?php
namespace Socketlabs;

class RetrySettings{

    const DEFAULT_NUMBER_OF_RETRIES = 0;
    const MAXIMUM_ALLOWED_NUMBER_OF_RETRIES = 5;
    const MINIMUM_RETRY_TIME = 1;
    const MAXIMUM_RETRY_TIME = 10;

    private $maximumNumberOfRetries;

    public function __construct($maximumNumberOfRetries=null){

        if (!is_null($maximumNumberOfRetries)){

            if ($maximumNumberOfRetries < 0) {throw new InvalidArgumentException("maximumNumberOfRetries must be greater than 0");}
            if ($maximumNumberOfRetries > self::MAXIMUM_ALLOWED_NUMBER_OF_RETRIES) {throw new InvalidArgumentException("The maximum number of allowed retries is ".self::MAXIMUM_ALLOWED_NUMBER_OF_RETRIES);}

            $this->maximumNumberOfRetries = $maximumNumberOfRetries;
        }
        else{
            $this->maximumNumberOfRetries = self::DEFAULT_NUMBER_OF_RETRIES;
        }
    }

    public function getMaximumNumberOfRetries(){
        return $this->maximumNumberOfRetries;
    }

    public function getNextWaitInterval($numberOfAttempts){
        $interval = (int)min(
            ((self::MINIMUM_RETRY_TIME * 1000) + RetrySettings::getRetryDelta($numberOfAttempts)),
            (self::MAXIMUM_RETRY_TIME * 1000) 
        );
        return $interval;
    }

    private static function getRetryDelta($numberOfAttempts){
        $min = (int)(1 * 1000 * 0.8);
        $max = (int)(1 * 1000 * 1.2);
        return (int)((pow(2.0, $numberOfAttempts) - 1.0) * rand($min, $max));
    }

}
