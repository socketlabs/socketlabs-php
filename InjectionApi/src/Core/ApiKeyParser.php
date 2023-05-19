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
            $result = ApiKeyParseResult::InvalidEmptyOrWhitespace;
            return $result;
        }

        if (strlen($wholeApiKey) !== 61)
        {
            $result = ApiKeyParseResult::InvalidKeyLength;
            return $result;
        }

        $splitPosition = strpos($wholeApiKey, '.');

        if ($splitPosition === false)
        {
            $result = ApiKeyParseResult::Invalid;
            return $result;
        }

        //extract the public part
        $maxCount = min(50, strlen($wholeApiKey));

        if ($splitPosition === false)
        {
            $result = ApiKeyParseResult::InvalidUnableToExtractPublicPart;
            return $result;
        }

        $publicPart = substr($wholeApiKey,0, $splitPosition);

        if (strlen($publicPart) !== 20)
        {
            $result = ApiKeyParseResult::InvalidPublicPartLength;
            return $result;
        }

        $privatePart = substr($wholeApiKey, ($splitPosition + 1), strlen($wholeApiKey));

        if (strlen($privatePart) !== 40)
        {
            $result = ApiKeyParseResult::InvalidSecretPartLength;
            return $result;
        }

        $result = ApiKeyParseResult::Success;
        return $result;
    }
}