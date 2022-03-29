<?php
/**
 * @licence Proprietary
 */
namespace MyCow\SDK\Model;

/**
 * Class HttpTransferAdapter
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
interface HttpTransferAdapter
{
    /**
     * @param string $url
     * @param array $data Query parameters
     * @param array $headers
     *
     * @return ResponseInterface
     */
    function get($url, array $data, array $headers = []);

    /**
     * @param string $url
     * @param array $data
     * @param array $headers
     *
     * @return ResponseInterface
     */
    function post($url, array $data, array $headers = []);

    /**
     * @param string $url
     * @param array $data
     * @param array $headers
     *
     * @return ResponseInterface
     */
    function put($url, array $data, array $headers = []);

    /**
     * @param string $url
     * @param array $data
     * @param array $headers
     *
     * @return ResponseInterface
     */
    function delete($url, array $data, array $headers = []);
}
