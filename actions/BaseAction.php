<?php
/**
 * @link https://pix.st/
 * @copyright Copyright (c) 2015 Pix Street
 * @license MIT License https://opensource.org/licenses/MIT
 */

namespace pixst\actions;

use yii\base\Component;

class BaseAction extends Component
{
    protected $_client;
    protected $_name;
    protected $_params = [];

    /**
     * @var boolean Whether action was successful
     */
    protected $_success;

    /**
     * @var array Action result on success
     */
    protected $_result;

    /**
     * @var array Action error on failure
     */
    protected $_error;

    /**
     * Constructor
     *
     * @param \pixst\Client $client client
     */
    public function __construct($client)
    {
        $this->_client = $client;
    }

    /**
     * Executes action
     *
     * @return self
     */
    public function execute()
    {
        $result = $this->_client->execute($this);

        $this->_success = $result['success'];

        if ($result['success']) {
            $this->_result = $result['result'];
        } else {
            $this->_error = $result['error'];
        }

        return $this;
    }

    /**
     * Returns action params
     *
     * @return array action params
     */
    public function getParams()
    {
        return ['action' => $this->_name] + $this->_params;
    }

    /**
     * Returns action result
     *
     * @return array Action result
     */
    public function getResult()
    {
        return $this->_result;
    }

    /**
     * Returns whether action was successful
     *
     * @return boolean Whether action was successful
     */
    public function isSuccessful()
    {
        return $this->_success;
    }

    /**
     * Returns action error
     *
     * @return array Action error
     */
    public function getError()
    {
        return $this->_error;
    }

    /**
     * Returns whether action failed
     *
     * @return boolean Whether action failed
     */
    public function hasError()
    {
        return !$this->_success;
    }
}
