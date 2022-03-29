<?php
/**
 * @licence Proprietary
 */
namespace MyCow\SDK;

use MyCow\SDK\Api\User;
use MyCow\SDK\Model\HttpTransferAdapter;
use MyCow\SDK\Model\ResponseInterface;

/**
 * Class Core
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class Core
{
    /** @var string */
    protected $baseUrl;
    
    /** @var string */
    protected $token;
    
    /** @var HttpTransferAdapter */
    protected $adapter;
    
    /** @var User|null */
    protected $user;

    /**
     * Core constructor
     *
     * @param string $baseUrl Depend on your whitelabel. For instance https://www.mycow.eu (without tailing slash)
     * @param string $token Your access token given my MyCow
     * @param HttpTransferAdapter $adapter
     */
    public function __construct($baseUrl, $token, HttpTransferAdapter $adapter)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->token = trim($token);
        $this->adapter = $adapter;
    }
    
    protected function getHeaders()
    {
        return [
            'X-AUTH-TOKEN:'.$this->token,
            'Content-Type:application/x-www-form-urlencoded',
        ];
    }

    /**
     * @param $type
     * @param $url
     * @param $data
     * @param $headers
     *
     * @return ResponseInterface
     */
    public function request($type, $url, $data = [], $headers = [])
    {
        return call_user_func_array([$this->adapter, strtolower($type)], [
            $this->baseUrl.$url,
            $data,
            array_merge($this->getHeaders(), $headers),
        ]);
    }

    /**
     * @return User
     */
    public function getUser()
    {
        if (!$this->user) {
            $this->user = new User($this);
        }
        
        return $this->user;
    }
}
