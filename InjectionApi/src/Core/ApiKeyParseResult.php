<?php

namespace Socketlabs\Core;

/**
 *  A code describing the result of an attempt to parse an Api key.
 */
abstract class ApiKeyParseResult
{
        /// <summary>
        /// No result could be produced.
        /// </summary>
        const None = "None";
        /// <summary>
        /// The key was found to be the improper length.
        /// </summary>
        const InvalidKeyLength = "InvalidKeyLength";
        /// <summary>
        /// The key was found to be blank or invalid.
        /// </summary>
        const InvalidEmptyOrWhitespace = "InvalidEmptyOrWhitespace";
        /// <summary>
        /// The key was found to be blank or invalid.
        /// </summary>
        const Invalid = "Invalid";
        /// <summary>
        /// The public portion of the key was unable to be parsed.
        /// </summary>
        const InvalidUnableToExtractPublicPart = "InvalidUnableToExtractPublicPart";
        /// <summary>
        /// The secret portion of the key was unable to be parsed.
        /// </summary>
        const InvalidUnableToExtractSecretPart = "InvalidUnableToExtractSecretPart";
        /// <summary>
        /// The public portion of the key has an invalid length.
        /// </summary>
        const InvalidPublicPartLength = "InvalidPublicPartLength";
        /// <summary>
        /// The secret portion of the key has an invalid length.
        /// </summary>
        const InvalidSecretPartLength = "InvalidSecretPartLength";
        /// <summary>
        /// Key was successfully parsed.
        /// </summary>
        const Success = "Success";
}