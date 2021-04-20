<?php
namespace Socketlabs;

class RetrySettings{

    const DEFAULT_NUMBER_OF_RETRIES = 0;
    const MAXIMUM_ALLOWED_NUMBER_OF_RETRIES = 5;
    const MINIMUM_RETRY_TIME = 1;
    const MAXIMUM_RETRY_TIME = 10;

    private $maximumNumberOfRetries;

    public function __construct($maximumNumberOfRetries=null){
        $log = fopen('d:\\log.txt', 'a') or die("unable to open file");
        fwrite($log, "In Retry Settings Constructor : ".$maximumNumberOfRetries."\n");
        fclose($log);
        if (!is_null($maximumNumberOfRetries)){

            $log = fopen('d:\\log.txt', 'a') or die("unable to open file");
            fwrite($log, "maximumNumberOfRetries is not null\n");
            fclose($log);

            if ($maximumNumberOfRetries < 0) {throw new InvalidArgumentException("maximumNumberOfRetries must be greater than 0");}
            if ($maximumNumberOfRetries > self::MAXIMUM_ALLOWED_NUMBER_OF_RETRIES) {throw new InvalidArgumentException("The maximum number of allowed retries is ".self::MAXIMUM_ALLOWED_NUMBER_OF_RETRIES);}

            $this->maximumNumberOfRetries = $maximumNumberOfRetries;
            $log = fopen('d:\\log.txt', 'a') or die("unable to open file");
            fwrite($log, "maximumNumberOfRetries is set to : ".$maximumNumberOfRetries."\n");
            fclose($log);
        }
        else{
            $this->maximumNumberOfRetries = self::DEFAULT_NUMBER_OF_RETRIES;
            $log = fopen('d:\\log.txt', 'a') or die("unable to open file");
            fwrite($log, "maximumNumberOfRetries is a null\n");
            fclose($log);
        }
    }

    public function getMaximumNumberOfRetries(){
        return $this->maximumNumberOfRetries;
    }

    public function getNextWaitInterval($numberOfAttempts){
        $log = fopen('d:\\log.txt', 'a') or die("unable to open file");
        fwrite($log, "In getNextWaitInterval\n");
        fclose($log);
        $interval = (int)min(
            ((self::MINIMUM_RETRY_TIME * 1000) + RetrySettings::getRetryDelta($numberOfAttempts)),
            (self::MAXIMUM_RETRY_TIME * 1000) 
        );
        $log = fopen('d:\\log.txt', 'a') or die("unable to open file");
        fwrite($log, "Interval : ".$interval."\n");
        fclose($log);
        return $interval;
    }

    private static function getRetryDelta($numberOfAttempts){
        $min = (int)(1 * 1000 * 0.8);
        $max = (int)(1 * 1000 * 1.2);
        return (int)((pow(2.0, $numberOfAttempts) - 1.0) * rand($min, $max));
    }

}
