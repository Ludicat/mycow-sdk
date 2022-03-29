<?php
/**
 * @licence Proprietary
 */
namespace MyCow\SDK\Adapter;

use MyCow\SDK\Response;

/**
 * Class CurlAdapter
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class CurlAdapter extends AbstractAdapter
{
    /** @var int */
    protected $timeout;
    
    /**
     * CurlAdapter constructor
     *
     * @param $timeout
     */
    public function __construct($timeout = 3)
    {
        $this->timeout = $timeout;
    }

    /**
     * @param string $url
     * @param array $data
     * @param array $headers
     *
     * @return \MyCow\SDK\Model\ResponseInterface|void
     */
    public function get($url, array $data = [], array $headers = [])
    {
        if (count($data)) {
            if (false === strpos($url, '?')) {
                $url .= '?';
            } else {
                $parts = explode('?', $url);
                $url = array_shift($parts).'?';
            }

            $url .= http_build_query($data);
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        return $this->execute($ch);
    }

    /**
     * @param string $url
     * @param array $data
     * @param array $headers
     *
     * @return \MyCow\SDK\Model\ResponseInterface|void
     */
    public function post($url, array $data, array $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        return $this->execute($ch);
    }

    /**
     * @param string $url
     * @param array $data
     * @param array $headers
     *
     * @return \MyCow\SDK\Model\ResponseInterface|Response
     */
    public function put($url, array $data, array $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        return $this->execute($ch);
    }

    /**
     * @param string $url
     * @param array $data
     * @param array $headers
     *
     * @return \MyCow\SDK\Model\ResponseInterface|void
     */
    public function delete($url, array $data, array $headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        return $this->execute($ch);
    }

    /**
     * @param resource $ch Curl handler
     *
     * @return Response
     */
    protected function execute($ch)
    {
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $body = curl_exec($ch);
        $message = null;
        if (curl_errno($ch)) {
            $message = curl_error($ch);
            // Reuse message as body for easier integration
            $body = $body ?: $message;
        }
        
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
        
        return new Response(
            $http_code,
            $message,
            $body
        );
    }
}
