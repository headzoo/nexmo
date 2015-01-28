<?php
namespace Headzoo\Nexmo\Exception;

/**
 * You have exceeded the submission capacity allowed on this account, please back-off and retry.
 */
class ThrottledException
    extends Exception {}