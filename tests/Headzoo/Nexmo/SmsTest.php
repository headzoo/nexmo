<?php
use Headzoo\Nexmo\Response;
use Headzoo\Nexmo\Message;
use Headzoo\Nexmo\Sms;

/**
 * @coversDefaultClass Sms
 */
class SmsTest
    extends PHPUnit_Framework_TestCase
{
    protected $key    = "n3xm0rocks";
    protected $secret = "12ab34cd";
    protected $from   = "15555555555";
    
    /**
     * @covers ::text
     */
    public function testText()
    {
        $sms = new Sms($this->getMockGuzzle("12015555555", "Testing", "My ref"));
        $sms->setKey($this->key)
            ->setSecret($this->secret)
            ->setFrom($this->from);

        $response = $sms->text("12015555555", "Testing", "My ref");
        $this->assertInstanceOf(
            Response::class,
            $response
        );
        $this->assertEquals(
            1,
            $response->count()
        );
        $this->assertEquals(
            "12015555555",
            $response->getMessages()[0]->getTo()
        );
        $this->assertEquals(
            "My ref",
            $response->getMessages()[0]->getClientRef()
        );
        
        $count = 0;
        foreach($response as $message) {
            if ($message instanceof Message) {
                $count++;
            }
        }
        $this->assertEquals(1, $count);
    }

    /**
     * @covers ::text
     * @expectedException Headzoo\Nexmo\Exception\ThrottledException
     */
    public function testTextThrottledException()
    {
        $guzzle = $this->getMockGuzzle("12015555555", "Testing", "My ref", 1, "Messages throttled");
        $sms    = new Sms($guzzle);
        $sms->setKey($this->key)
            ->setSecret($this->secret)
            ->setFrom($this->from);
        $sms->text("12015555555", "Testing", "My ref");
    }

    /**
     * @param $to
     * @param $message
     * @param $client_ref
     * @param $status
     * @param $error_text
     *
     * @return PHPUnit_Framework_MockObject_MockObject|GuzzleHttp\ClientInterface
     */
    protected function getMockGuzzle($to, $message, $client_ref, $status = 0, $error_text = null)
    {
        $response = $this->getMock(GuzzleHttp\Message\ResponseInterface::class);
        $response->expects($this->once())
            ->method("json")
            ->willReturn(
                [
                    "message-count" => 1,
                    "messages"      => [
                        [
                            "to"                => $to,
                            "message-id"        => "140000005741112B",
                            "status"            => $status,
                            "remaining-balance" => 11.90880000,
                            "message-price"     => 0.00480000,
                            "client-ref"        => $client_ref,
                            "network"           => "310004",
                            "error-text"        => $error_text
                        ]
                    ]
                ]
            );

        $guzzle = $this->getMock(GuzzleHttp\ClientInterface::class);
        $guzzle->expects($this->once())
            ->method("get")
            ->with(
                Sms::API_URI,
                [
                    "query" => [
                        "to"                => $to,
                        "type"              => "text",
                        "text"              => $message,
                        "client-ref"        => $client_ref,
                        "api_key"           => $this->key,
                        "api_secret"        => $this->secret,
                        "from"              => $this->from,
                        "status-report-req" => 0
                    ]
                ]
            )
            ->willReturn($response);
        
        return $guzzle;
    }
}