<?php
namespace Headzoo\Nexmo\Exception;

/**
 * This account is not provisioned for REST submission, you should use SMPP instead.
 */
class AccountNotEnabledForRestException
    extends Exception {}