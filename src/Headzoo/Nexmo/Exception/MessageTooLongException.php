<?php
namespace Headzoo\Nexmo\Exception;

/**
 * Applies to Binary submissions, where the length of the UDH and the message body combined exceed 140 octets.
 */
class MessageTooLongException
    extends Exception {}