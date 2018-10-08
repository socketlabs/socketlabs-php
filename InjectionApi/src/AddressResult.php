<?php
namespace Socketlabs;
/**
 * The result of a single recipient in the Injection request.
 */
class AddressResult{

    /**
     * The recipient's email address.
     */
    public $emailAddress;

    /**
     * Whether the recipient was accepted for delivery.
     */
    public $accepted;

    /**
     * An error code detailing why the recipient was not accepted.
     */
    public $errorCode;
}