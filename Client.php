<?php
/**
 * @link https://pix.st/
 * @copyright Copyright (c) 2015 Pix Street
 * @license MIT License https://opensource.org/licenses/MIT
 */

namespace pixst;

use yii\base\Component;

use pixst\actions\AccountInfoAction;
use pixst\actions\ImageCreateAction;
use pixst\actions\ImageDeleteAction;
use pixst\actions\ImageDownloadAction;
use pixst\actions\ImageInfoAction;
use pixst\Connection;

/**
 * Client is the main class of the Pix Street API library
 */
class Client extends Component
{
    /**
     * Channel
     * @var string $_channel
     */
    protected $_channer = Connection::CHANNEL_CURL;

    /**
     * Instance of Connection class used to access Pix Street API server
     * @var Connection $_conn
     */
    protected $_conn;

    /**
     * Initializes component
     */
    public function init()
    {
        $this->_conn = new Connection($channel);
    }

    /**
     * Sets API ID
     *
     * @param string $apiID API ID
     */
    public function setApiID($apiID)
    {
        $this->_conn->addHeader('API-ID', $apiID);
    }

    /**
     * Sets API key
     *
     * @param string $apiKey API key
     * @return Client the client object itself
     */
    public function setApiKey($apiKey)
    {
        $this->_conn->addHeader('API-Key', $apiKey);

        return $this;
    }

    /**
     * Sets channel
     *
     * @param string $channel channel
     * @return Client the client object itself
     */
    public function setChannel($channel)
    {
        $this->_channel = $channel;

        return $this;
    }

    /**
     * Returns AccountInfoAction
     *
     * @return AccountInfoAction
     */
    public function accountInfo()
    {
        return new AccountInfoAction($this);
    }

    /**
     * Returns ImageCreateAction
     *
     * @return ImageCreateAction
     */
    public function imageCreate()
    {
        return (new ImageCreateAction($this))->setPublic(false)->setShorten(false);
    }

    /**
     * Returns ImageDeleteAction
     *
     * @return ImageDeleteAction
     */
    public function imageDelete()
    {
        return new ImageDeleteAction($this);
    }

    /**
     * Returns ImageDownloadAction
     *
     * @return ImageDownloadAction
     */
    public function imageDownload()
    {
        return new ImageDownloadAction($this);
    }

    /**
     * Returns ImageInfoAction
     *
     * @return ImageInfoAction
     */
    public function imageInfo()
    {
        return new ImageInfoAction($this);
    }
}
