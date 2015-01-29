<?php
namespace Headzoo\Nexmo;

use GuzzleHttp;

/**
 * Used to send text messages using the Nexmo API.
 */
class Sms
{
    /**
     * The Nexmo API URI.
     */
    const API_URI = "https://rest.nexmo.com/sms/json";

    /**
     * @var GuzzleHttp\ClientInterface
     */
    protected $guzzle;
    
    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var string
     */
    protected $from;

    /**
     * @var int
     */
    protected $ttl = 0;

    /**
     * @var int
     */
    protected $status_report_req = 0;

    /**
     * Creates and returns a new Sms instance
     * 
     * @param string $key    Your API key
     * @param string $secret Your API secret
     * @param string $from   Sender address
     *
     * @return Sms
     */
    public static function factory($key, $secret, $from)
    {
        $sms = new Sms(new GuzzleHttp\Client());
        $sms->setKey($key)
            ->setSecret($secret)
            ->setFrom($from);
        
        return $sms;
    }

    /**
     * Constructor
     * 
     * @param GuzzleHttp\ClientInterface $guzzle
     */
    public function __construct(GuzzleHttp\ClientInterface $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    /**
     * Sets your API key
     * 
     * @param string $key Ex: n3xm0rocks
     *
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;
        
        return $this;
    }

    /**
     * Sets your API secret
     * 
     * @param string $secret Ex: 12ab34cd
     *
     * @return $this
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
        
        return $this;
    }

    /**
     * Sets the sender address for each sent message
     * 
     * @param string $from May be alphanumeric (Ex: from=MyCompany20)
     *
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = $from;
        
        return $this;
    }

    /**
     * Returns the sender address for each sent message
     * 
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Sets the life span of sent messages in milliseconds
     * 
     * @param int $ttl Number of milliseconds
     *
     * @return $this
     */
    public function setTimeToLive($ttl)
    {
        $this->ttl = $ttl;
        
        return $this;
    }

    /**
     * Returns the life span of sent messages in milliseconds
     * 
     * @return int
     */
    public function getTimeToLive()
    {
        return $this->ttl;
    }

    /**
     * Set to true if you want to receive a delivery report (DLR) for each request
     * 
     * Make sure to configure your "Callback URL" in your "API Settings".
     * 
     * @param bool $status_report_req True to receive status reports
     *
     * @return $this
     */
    public function setStatusReportRequest($status_report_req)
    {
        $this->status_report_req = $status_report_req ? 1 : 0;
        
        return $this;
    }

    /**
     * Returns true if you want to receive a delivery report (DLR) for each request
     * 
     * @return bool
     */
    public function getStatusReportRequest()
    {
        return (bool)$this->status_report_req;
    }

    /**
     * Sends a text message
     * 
     * Returns a Response object representing the response from the Nexmo API. When the response contains
     * errors the last error will be thrown as an exception.
     * 
     * @param string $to         Mobile number in international format, and one recipient per request
     * @param string $message    Body of the text message (with a maximum length of 3200 characters)
     * @param string $client_ref Include any reference string for your reference. Useful for your internal reports (40 characters max)
     * 
     * @return Response
     * @throws Exception\Exception
     */
    public function text($to, $message, $client_ref = null)
    {
        return $this->send([
            "to"         => $to,
            "type"       => "text",
            "text"       => $this->mbstring($message),
            "client-ref" => $this->mbstring($client_ref)
        ]);
    }

    /**
     * Sends a request to the Nexmo API
     * 
     * @param array $query The query parameters
     *
     * @return Response
     * @throws Exception\Exception
     */
    protected function send(array $query)
    {
        if (!$this->key || !$this->secret || !$this->from) {
            throw new Exception\ConfigurationException(
                "Invalid configuration. Missing key, secret, or from."
            );
        }
        
        $query["api_key"]           = $this->key;
        $query["api_secret"]        = $this->secret;
        $query["from"]              = $this->from;
        $query["status-report-req"] = $this->status_report_req;
        if ($this->ttl) {
            $query["ttl"] = $this->ttl;
        }
        
        $response = $this->guzzle->get(self::API_URI, [
            "query" => $query
        ])->json();

        /**
         * @var Message[] $messages
         * @var Exception\Exception[] $exceptions
         */
        $messages   = [];
        $exceptions = [];
        foreach($response["messages"] as $message) {
            if ($message["status"] != 0) {
                $exceptions[] = Exception\Factory::factory(
                    $message["error-text"],
                    $message["status"]
                );
            } else {
                $messages[] = new Message($message);
            }
        }
        
        $response = new Response($messages, $exceptions);
        if ($exceptions) {
            $exceptions[0]->setResponse($response);
            throw $exceptions[0];
        }
        
        return $response;
    }

    /**
     * Converts a string to UTF-8 when the mbstring extension is loaded
     * 
     * @param string $str
     *
     * @return string
     */
    protected function mbstring($str)
    {
        if (extension_loaded("mbstring")) {
            $str = mb_convert_encoding($str, "UTF-8");
        }
        
        return $str;
    }
}