<?php
namespace Socketlabs\Core\Enums;

/**
 *  A code describing the result of an attempt to parse an Api key.
 */
    enum ApiKeyParseResult {
	    /// <summary>
        /// No result could be produced.
        /// </summary>
        case None;
        /// <summary>
        /// The key was found to be the improper length.
        /// </summary>
        case InvalidKeyLength;
        /// <summary>
        /// The key was found to be blank or invalid.
        /// </summary>
        case InvalidEmptyOrWhitespace;
        /// <summary>
        /// The key was found to be blank or invalid.
        /// </summary>
        case Invalid;
        /// <summary>
        /// The public portion of the key was unable to be parsed.
        /// </summary>
        case InvalidUnableToExtractPublicPart;
        /// <summary>
        /// The secret portion of the key was unable to be parsed.
        /// </summary>
        case InvalidUnableToExtractSecretPart;
        /// <summary>
        /// The public portion of the key has an invalid length.
        /// </summary>
        case InvalidPublicPartLength;
        /// <summary>
        /// The secret portion of the key has an invalid length.
        /// </summary>
        case InvalidSecretPartLength;
        /// <summary>
        /// Key was successfully parsed.
        /// </summary>
        case Success;
}