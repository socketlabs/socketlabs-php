<?php

namespace Socketlabs\Core;

/**
 * Represents a injection request for sending to the Injection Api.
 */
class InjectionRequest
{

    /**
     * list of messages to be sent.
     */
    public $Messages;

    /**
     * Your SocketLabs ServerId number.
     */
    public $ServerId;

    /**
     * Your SocketLabs Injection API key.
     */
    public $ApiKey;

    /**
     * Creates a new instance of the InjectionRequest class.
     * @param serverId
     * @param apiKey
     */
    public function __construct($serverId, $apiKey)
    {
        $this->ServerId = (int)$serverId;
        $this->ApiKey = $apiKey;

        $this->Messages = array();
    }
}
