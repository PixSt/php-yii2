<?php
/**
 * @link https://pix.st/
 * @copyright Copyright (c) 2015 Pix Street
 * @license MIT License https://opensource.org/licenses/MIT
 */

namespace pixst;

use yii\base\Component;

/**
 * Action class
 */
class Action extends Component
{
    /**
     * @var integer Action ID
     */
    protected $_id;

    /**
     * @var array Action params
     */
    protected $_params;

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
     * @param integer $id Action ID
     * @param array $params Action params
     */
    public function __construct($id, $params)
    {
        $this->_id = $id;
        $this->_params = $params;
    }

    /**
     * Returns action ID
     *
     * @return integer Action ID
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Returns action params
     *
     * @return array Action params
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * Sets action params
     *
     * @param array $params Action params
     */
    public function setParams($params)
    {
        $this->_params = $params;
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
     * Sets action result
     *
     * @param array Action result
     */
    public function setResult($result)
    {
        $this->_success = $result['success'];

        if ($result['success']) {
            $this->_result = $result['result'];
        } else {
            $this->_error = $result['error'];
        }
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
     * Returns whether action was successful
     *
     * @return boolean Whether action was successful
     */
    public function getIsSuccessful()
    {
        return $this->isSuccessful();
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

    /**
     * Returns whether action failed
     *
     * @return boolean Whether action failed
     */
    public function getHasError()
    {
        return $this->hasError();
    }
}
