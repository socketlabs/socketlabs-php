<?php
namespace Socketlabs\Core;
/**
 *  Contains the method for parsing the Api Key.
 */
class ApiKeyParser {
    
    /** Parse the API key to determine what kind of key was provided
    . */
    public function parse($wholeApiKey)
    {
        if ($wholeApiKey == null || trim($wholeApiKey) == '')
        {
            $result = ApiKeyParseResultCode::InvalidEmptyOrWhitespace;
            return $result;
        }

        if (strlen($wholeApiKey) !== 61)
        {
            $result = ApiKeyParseResultCode::InvalidKeyLength;
            return $result;
        }
        
        $splitPosition = strpos($wholeApiKey, '.');

        if ($splitPosition === false)
        {
            $result = ApiKeyParseResultCode::Invalid;
            return $result;
        }

        //extract the public part

        $maxCount = min(50, strlen($wholeApiKey));

        if ($splitPosition === false)
        {
            $result = ApiKeyParseResultCode::InvalidUnableToExtractPublicPart;
            return $result;
        }

        $firstSection = substr($wholeApiKey,0, 50);
        $publicPartEnd = substr($firstSection, 0, $splitPosition);

        $publicPart = substr($wholeApiKey, 0, $publicPartEnd);

        if (strlen($publicPart) !== 20)
        {
            $result = ApiKeyParseResultCode::InvalidPublicPartLength;
            return $result;
        }

        if (strlen($wholeApiKey) <= $publicPartEnd + 1)
        {
            $result = ApiKeyParseResultCode::InvalidUnableToExtractSecretPart;
            return $result;
        }
        
        $privatePart = substr($wholeApiKey, $publicPartEnd +1);
        
        if (strlen($privatePart) !== 40)
        {
            $result = ApiKeyParseResultCode::InvalidSecretPartLength;
            return $result;
        }

        $result = ApiKeyParseResultCode::Success;
        return $result;
    }
}