<?php
/**
 * @licence Proprietary
 */
namespace MyCow\SDK\Api;

use MyCow\SDK\Core;

/**
 * Class AbstractApi
 *
 * @author Joseph LEMOINE <j.lemoine@ludi.cat>
 */
abstract class AbstractApi
{
    /** @var Core */
    protected $core;

    /**
     * User constructor
     *
     * @param Core $core
     */
    public function __construct(Core $core)
    {
        $this->core = $core;
    }
}
