<?php
namespace Headzoo\Nexmo\Exception;

/**
 * The Nexmo platform was unable to process this message, for example, an un-recognized
 * number prefix or the number is not whitelisted if your account is new.
 */
class InvalidMessageException
    extends Exception {}