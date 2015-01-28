<?php
namespace Headzoo\Nexmo\Exception;

use Headzoo\Nexmo\Response;

/**
 * Base exception.
 */
class Exception
    extends \Exception
{
    /**
     * @var Response
     */
    private $response;

    /**
     * Returns the response from the Nexmo API
     * 
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Sets the response from the Nexmo API
     * 
     * @param Response $response The response
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }
}
