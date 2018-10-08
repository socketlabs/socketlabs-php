<?php
namespace Socketlabs\Core;
/**
 * Used by the SocketLabsClient to convert the response form the Injection API.
 */
class InjectionResponseParser{

    /**
     * Parse the response from theInjection Api into SendResponse
     * @param $response
     * @param $responseHeader
     * @return SendResponse
     */
    public static function parse($response, $responseHeader){
        $newResponse;
        
        if($response){
            $injectionResponse = json_decode($response);

            $sendResult = InjectionResponseParser::DetermineSendResult($injectionResponse, $responseHeader);
    
            $newResponse = new \Socketlabs\SendResponse($sendResult);
            $newResponse->transactionReceipt = $injectionResponse->TransactionReceipt;
    
            if($sendResult == 'Warning') {
                 if ($injectionResponse->MessageResults && is_array($injectionResponse->MessageResults) && count($injectionResponse->MessageResults) > 0) {
                    $errorCode = $injectionResponse->MessageResults[0]['ErrorCode'];
                    $newResponse->Result = $errorCode;
                }
            } 
            
            if ($injectionResponse->MessageResults && is_array($injectionResponse->MessageResults) && count($injectionResponse->MessageResults) > 0) {
                $newResponse->AddressResults = $injectionResponse->MessageResults[0]->AddressResults; 
            }
    
           
        }
        else{
            $sendResult = InjectionResponseParser::DetermineSendResult(null, $responseHeader);
            $newResponse = new \Socketlabs\SendResponse($sendResult);
        }
        return $newResponse;

    }

    /**
     * Enumerated SendResult of the payload response from the Injection Api
     * @param $injectionResponse
     * @param $responseHeader
     * @return SendResult
     */
    private static function DetermineSendResult($injectionResponse, $responseHeader){
        $headers = InjectionResponseParser::parseHeaders($responseHeader);
        $statusCode = $headers['reponse_code'];

        switch ($statusCode) {
            case 200:  // 200 OK
                // Attempt to convert error code to SendResult enum
                $errorCode = \Socketlabs\SendResult::get_const($injectionResponse->ErrorCode);
                if ($errorCode == false) {
                    return \Socketlabs\SendResult::UnknownError; 
                } else {
                    return $errorCode;                   
                }
                break;
                
            case 500: // 500 Internal Server Error
                return \Socketlabs\SendResult::InternalError;
                break;

            case 408:  // 408 Request Timeout
                return \Socketlabs\SendResult::Timeout;
                break;
            
            case 401: // 401 Unauthorized
                return \Socketlabs\SendResult::InvalidAuthentication;
                break;

            default:
                return \Socketlabs\SendResult::UnknownError;
        }
    }

    /**
     * Helper function to parse headers
     * @param array $headers
     * @return array 
     * https://secure.php.net/manual/en/reserved.variables.httpresponseheader.php
     */
    private static function parseHeaders( $headers )
    {
        $head = array();
        foreach( $headers as $k=>$v )
        {
            $t = explode( ':', $v, 2 );
            if( isset( $t[1] ) )
                $head[ trim($t[0]) ] = trim( $t[1] );
            else
            {
                $head[] = $v;
                if( preg_match( "#HTTP/[0-9\.]+\s+([0-9]+)#",$v, $out ) )
                    $head['reponse_code'] = intval($out[1]);
            }
        }
        return $head;
    }
}