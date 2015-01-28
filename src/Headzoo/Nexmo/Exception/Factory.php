<?php
namespace Headzoo\Nexmo\Exception;

/**
 * Creates exceptions based on Nexmo status codes.
 */
class Factory
{
    /**
     * @var array
     */
    private static $map
        = [
            1  => ThrottledException::class,
            2  => MissingParamsException::class,
            3  => InvalidParamsException::class,
            4  => InvalidCredentialsException::class,
            5  => InternalErrorException::class,
            6  => InvalidMessageException::class,
            7  => NumberBarredException::class,
            8  => PartnerAccountBarredException::class,
            9  => PartnerQuotaExceededException::class,
            11 => AccountNotEnabledForRestException::class,
            12 => MessageTooLongException::class,
            13 => CommunicationFailedException::class,
            14 => InvalidSignatureException::class,
            15 => InvalidSenderAddressException::class,
            16 => InvalidTtlException::class,
            19 => FacilityNotAllowedException::class,
            20 => InvalidMessageClassException::class
        ];

    /**
     * Returns a new exception for the given status
     * 
     * @param string $message The error message
     * @param int    $status  The status code
     *
     * @return Exception
     */
    public static function factory($message, $status)
    {
        $class = self::$map[(int)$status];
        
        return new $class($message, $status);
    }
}