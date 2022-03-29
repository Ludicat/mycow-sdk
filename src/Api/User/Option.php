<?php
/**
 * @licence Proprietary
 */
namespace MyCow\SDK\Api\User;

use MyCow\SDK\Api\AbstractApi;
use MyCow\SDK\Model\ResponseInterface;

/**
 * Class Option
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
class Option extends AbstractApi
{
    const ENDPOINT = '/api/user/%s/option';

    /**
     * @param string $email
     * @param string $optionName
     * @param mixed $value
     *
     * @return ResponseInterface
     */
    public function put($email, $optionName, $value)
    {
        return $this->core->request('put', sprintf(static::ENDPOINT, $email), [
            'option' => $optionName,
            'value' => $value,
        ]);
    }
}
