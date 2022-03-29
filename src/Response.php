<?php
/**
 * @licence Proprietary
 */
namespace MyCow\SDK;

/**
 * Class Response
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class Response implements Model\ResponseInterface
{
    /**
     * Response constructor
     *
     * @param int|null $code
     * @param string|null $message
     * @param string|null $body
     */
    public function __construct($code, $message, $body)
    {
        $this->code = $code;
        $this->message = $message;
        
        $decodedBody = json_decode($body, true);
        if (false !== $decodedBody) {
            $body = $decodedBody;
        }
        
        $this->body = $body;
    }

    /** @var int|null */
    protected $code;
    
    /** @var string|null */
    protected $message;
    
    /** @var string|null */
    protected $body;

    /**
     * @return bool
     */
    function isError()
    {
        return $this->isCurlError() || $this->isHttpError();
    }

    /**
     * @return bool
     */
    function isCurlError()
    {
        return !empty($this->message);
    }

    /**
     * @return bool
     */
    function isHttpError()
    {
        return $this->code >= 400;
    }

    /**
     * @return int|null
     */
    function getCode()
    {
        return $this->code;
    }

    /**
     * @return string|null
     */
    function getMessage()
    {
        return $this->message;
    }

    /**
     * @return array|string|null
     */
    function getBody()
    {
        return $this->body;
    }
}
