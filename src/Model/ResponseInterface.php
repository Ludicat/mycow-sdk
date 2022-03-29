<?php
/**
 * @licence Proprietary
 */
namespace MyCow\SDK\Model;

/**
 * Interface ResponseInterface
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
interface ResponseInterface
{
    /**
     * @return bool
     */
    function isError();

    /**
     * HTTP response code
     * 
     * @return int
     */
    function getCode();

    /**
     * Message is filled on error
     * 
     * @return string|null
     */
    function getMessage();

    /**
     * If response expectation is a JSON, return an array
     * 
     * @return string|array
     */
    function getBody();
}
