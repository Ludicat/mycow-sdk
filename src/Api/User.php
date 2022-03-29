<?php
/**
 * @licence Proprietary
 */
namespace MyCow\SDK\Api;

use MyCow\SDK\Api\User\Option;
use MyCow\SDK\Core;
use MyCow\SDK\Model\ResponseInterface;

/**
 * Class User
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class User extends AbstractApi
{
    const ENDPOINT_USERNAME = '/api/user/%s/username';
    const ENDPOINT_UUID = '/api/user/%s';
    
    /** @var Option|null */
    protected $option;

    /**
     * @return Option
     */
    public function getOption()
    {
        if (!$this->option) {
            $this->option = new Option($this->core);
        }
        
        return $this->option;
    }

    /**
     * @param string $email
     * @param string $optionName
     * @param mixed $value
     *
     * @return ResponseInterface
     */
    public function get($usernameOrUuid)
    {
        if (preg_match('/\w{8}-\w{4}-\w{4}-\w{4}-\w{12}/', $usernameOrUuid)) {
            return $this->core->request('get', sprintf(static::ENDPOINT_UUID, $usernameOrUuid));
        }

        return $this->core->request('get', sprintf(static::ENDPOINT_USERNAME, $usernameOrUuid));
    }
}
