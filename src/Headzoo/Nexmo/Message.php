<?php
namespace Headzoo\Nexmo;

/**
 * Represents a single message response from the Nexmo API.
 */
class Message
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $to;

    /**
     * @var float
     */
    private $balance;

    /**
     * @var float
     */
    private $price;

    /**
     * @var string
     */
    private $network;

    /**
     * @var string
     */
    private $client_ref;

    /**
     * Constructor
     *
     * @param array $values The API response
     */
    public function __construct(array $values)
    {
        $this->id         = isset($values["message-id"]) ? $values["message-id"] : null;
        $this->to         = isset($values["to"]) ? $values["to"] : null;
        $this->balance    = isset($values["remaining-balance"]) ? $values["remaining-balance"] : null;
        $this->price      = isset($values["message-price"]) ? $values["message-price"] : null;
        $this->network    = isset($values["network"]) ? $values["network"] : null;
        $this->client_ref = isset($values["client-ref"]) ? $values["client-ref"] : null;
    }

    /**
     * Returns the ID of the message that was submitted
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the ID of the message that was submitted
     *
     * @param string $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns the recipient number
     *
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Sets the recipient number
     *
     * @param string $to
     *
     * @return $this
     */
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Returns the remaining account balance expressed in EUR
     *
     * @return float
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Sets the remaining account balance expressed in EUR
     *
     * @param float $balance
     *
     * @return $this
     */
    public function setBalance($balance)
    {
        $this->balance = (float)$balance;

        return $this;
    }

    /**
     * Returns the price charged (EUR) for the submitted message
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Sets the price charged (EUR) for the submitted message
     *
     * @param float $price
     *
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = (float)$price;

        return $this;
    }

    /**
     * Returns the identifier of the mobile network MCCMNC
     *
     * @see http://en.wikipedia.org/wiki/Mobile_country_code
     *
     * @return string
     */
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * Sets the identifier of the mobile network MCCMNC
     *
     * @see http://en.wikipedia.org/wiki/Mobile_country_code
     *
     * @param string $network
     *
     * @return $this
     */
    public function setNetwork($network)
    {
        $this->network = $network;

        return $this;
    }

    /**
     * Returns the client ref if you set a custom reference during your request
     *
     * @return string
     */
    public function getClientRef()
    {
        return $this->client_ref;
    }

    /**
     * Sets the client ref if you set a custom reference during your request
     *
     * @param string $client_ref
     *
     * @return $this
     */
    public function setClientRef($client_ref)
    {
        $this->client_ref = $client_ref;

        return $this;
    }
}