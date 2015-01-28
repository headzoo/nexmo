<?php
use Headzoo\Nexmo\Message;

/**
 * @coversDefaultClass Message
 */
class MessageTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::getId
     * @covers ::getTo
     * @covers ::getBalance
     * @covers ::getPrice
     * @covers ::getNetwork
     * @covers ::getClientRef
     */
    public function testMessage()
    {
        $values = [
            "message-id"        => "140000005741112B",
            "to"                => "12015555555",
            "remaining-balance" => 11.90880000,
            "message-price"     => 0.00480000,
            "network"           => "310004"
        ];
        $message = new Message($values);
        $this->assertEquals(
            "140000005741112B",
            $message->getId()
        );
        $this->assertEquals(
            "12015555555",
            $message->getTo()
        );
        $this->assertEquals(
            11.90880000,
            $message->getBalance()
        );
        $this->assertEquals(
            0.00480000,
            $message->getPrice()
        );
        $this->assertEquals(
            "310004",
            $message->getNetwork()
        );
        $this->assertNull($message->getClientRef());
    }
}