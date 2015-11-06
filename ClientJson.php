<?php
/**
 * @link https://pix.st/
 * @copyright Copyright (c) 2015 Pix Street
 * @license MIT License https://opensource.org/licenses/MIT
 */

namespace pixst;

use pixst\Client;
use pixst\Connection;

/**
 * ClientJson is a wrapper for Client class which forces usage of JSON for Pix Street API requests
 */
class ClientJson extends Client
{
    /**
     * Initialize component
     */
    public function init()
    {
        $this->setApiType('json');

        parent::init();
    }
}
