<?php
use Headzoo\Nexmo\Exception;

/**
 * @coversDefaultClass Exception\Factory
 */
class FactoryTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::factory
     * @dataProvider dataFactory
     */
    public function testFactory($status, $class)
    {
        $exception = Exception\Factory::factory("Testing", $status);
        $this->assertInstanceOf(
            $class,
            $exception
        );
        $this->assertEquals(
            "Testing",
            $exception->getMessage()
        );
        $this->assertEquals(
            $status,
            $exception->getCode()
        );
    }

    /**
     * @return array
     */
    public function dataFactory()
    {
        return [
            [1, Exception\ThrottledException::class],
            [2, Exception\MissingParamsException::class],
            [3, Exception\InvalidParamsException::class],
            [4, Exception\InvalidCredentialsException::class],
            [5, Exception\InternalErrorException::class],
            [6, Exception\InvalidMessageException::class],
            [7, Exception\NumberBarredException::class],
            [8, Exception\PartnerAccountBarredException::class],
            [9, Exception\PartnerQuotaExceededException::class],
            [11, Exception\AccountNotEnabledForRestException::class],
            [12, Exception\MessageTooLongException::class],
            [13, Exception\CommunicationFailedException::class],
            [14, Exception\InvalidSignatureException::class],
            [15, Exception\InvalidSenderAddressException::class],
            [16, Exception\InvalidTtlException::class],
            [19, Exception\FacilityNotAllowedException::class],
            [20, Exception\InvalidMessageClassException::class]
        ];
    }
}