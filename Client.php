<?php
/**
 * @link https://pix.st/
 * @copyright Copyright (c) 2015 Pix Street
 * @license MIT License https://opensource.org/licenses/MIT
 */

namespace pixst;

use pixst\Action;
use pixst\Connection;
use pixst\exceptions\ApiException;
use pixst\exceptions\ApiNotSupportedException;
use yii\base\Component;

/**
 * Client is the main class of the Pix Street API library
 */
class Client extends Component
{
    /**
     * Pix Street API type
     * @var string $_apiType
     */
    protected $_apiType;

    /**
     * Pix Street API key
     * @var string $_apiKey
     */
    protected $_apiKey;

    /**
     * Connection type
     * @var string $_connectionType
     */
    protected $_connectionType = Connection::CHANNEL_CURL;

    /**
     * Instance of Connection class used to access Pix Street API server
     * @var Connection $_conn
     */
    protected $_conn;

    /**
     * List of actions to perform
     * @var array $_actions
     */
    protected $_actions = [];

    /**
     * List of performed actions
     * @var array $_actions
     */
    protected $_results = [];

    /**
     * List of asynchronous actions to wait for
     * @var array $_wait
     */
    protected $_wait = [];

    /**
     * Constructor
     *
     * @param string $apiKey Pix Street API key
     * @param string $channel Type of channel to use. Currently 'curl' is the only supported channel.
     */
    public function init()
    {
        $this->_conn = new Connection($this->_connectionType);

        switch ($this->_apiType) {
            case 'json':
                $this->_conn->addHeader('Content-Type', 'application/json');
                $this->_conn->addHeader('Accept', 'application/json');
                break;
            default:
                throw new ApiNotSupportedException('API "' . $api . '" is not supported');
        }

        $this->_conn->addHeader('Api-Key', $this->_apiKey);
    }

    /**
     * Sets API type.
     * 
     * @param string $apiType Type of API to use. Currently 'json' is the only supported API type.
     */
    public function setApiType($apiType)
    {
        $this->_apiType = $apiType;
    }

    /**
     * Sets API key
     *
     * @param string $apiKey API key
     * @return Client the client object itself
     */
    public function setApiKey($apiKey)
    {
        $this->_apiKey = $apiKey;

        return $this;
    }

    /**
     * Sets connection type.
     * 
     * @param string $type Connection type.
     */
    public function setConnectionType($connectionType)
    {
        $this->_connectionType = $connectionType;
    }

    /**
     * Get account information and statistics
     *
     * @param boolean $balance Include balance info in response
     * @param boolean $storage Include storage capacity and usage in response
     * @param boolean $albums Include number of albums in response
     * @param boolean $images Include number of images in response
     * @return Action The action object
     */
    public function accountInfo($balance = false, $storage = false, $albums = false, $images = false)
    {
        return $this->addAction([
            'action'  => 'account-info',
            'balance' => $balance,
            'storage' => $storage,
            'albums'  => $albums,
            'images'  => $images,
        ]);
    }

    /**
     * Create album
     *
     * @param string $id Unique album ID. Max length - 100 characters
     * @param string $name Album name. Max length - 100 characters
     * @return Action The action object
     */
    public function albumCreate($id, $name = null)
    {
        $action = [
            'action' => 'album-create',
            'id'     => $id,
        ];

        if ($name !== null) {
            $action['name'] = $name;
        }

        return $this->addAction($action);
    }

    /**
     * Get album info
     *
     * @param string $id Album ID
     * @return Action The action object
     */
    public function albumInfo($id)
    {
        return $this->addAction([
            'action' => 'album-info',
            'id'     => $id,
        ]);
    }

    /**
     * Remove album
     *
     * @param string $id Album ID
     * @return Action The action object
     */
    public function albumRemove($id)
    {
        return $this->addAction([
            'action' => 'album-remove',
            'id'     => $id,
        ]);
    }

    /**
     * Find albums matching the given criteria
     *
     * @param integer|array $images Filter by number of images
     * @param integer|array $storage Filter by sum of file sizes of images
     * @param string|array $created Filter by album creation time (format - ISO 8601)
     * @param integer $offset Skip first {offset} albums in results
     * @param integer $limit Return no more than {limit} albums in result
     * @return Action The action object
     */
    public function albumSearch($images = null, $storage = null, $created = null, $offset = 0, $limit = 100)
    {
        $action = [
            'action' => 'album-search',
        ];

        $params = [
            'images',
            'storage',
            'created',
            'offset',
            'limit',
        ];

        foreach ($params as $param) {
            if ($$param !== null) {
                $action[$param] = $$param;
            }
        }

        return $this->addAction($action);
    }

    /**
     * Update album. Allows to set/change album name.
     *
     * @param string $id Album ID
     * @param string $name Album name. Max length - 100 characters
     * @return Action The action object
     */
    public function albumUpdate($id, $name)
    {
        return $this->addAction([
            'action' => 'album-update',
            'id'     => $id,
            'name'   => $name,
        ]);
    }

    /**
     * Create image
     *
     * @param string $id Unique image ID. Max length - 100 characters
     * @param array $source Image source
     * @param boolean $public Generate public URL
     * @param boolean $shorten Shorten public URL
     * @param string album Album ID to put image in
     * @param string $name Image name. Max length - 100 characters
     * @param array $tags List of tags. Max number of tags - 50. Max length of tag - 50 characters.
     * @param mixed $metadata User-defined metadata. Max length of JSON-serialized string - 5000 characters.
     * @param array $rotate Rotate image by angle
     * @param array $resize Resize image
     * @param array $crop Crop image
     * @param integer $quality JPEG quality for rotated/resized/cropped image. Possible values: 1-100. Default - 95
     * @return Action The action object
     */
    public function imageCreate($id, $source, $public, $shorten = false, $album = null, $name = null, $tags = null, $metadata = null, $rotate = null, $resize = null, $crop = null, $quality = null)
    {
        $action = [
            'action' => 'image-create',
            'id'     => $id,
            'source' => $source,
            'public' => $public,
        ];

        if ($public && $shorten !== null) {
            $action['shorten'] = $shorten;
        }

        if ($album) {
            $action['album'] = $album;
        }

        if ($name) {
            $action['name'] = $name;
        }

        if ($tags) {
            $action['tags'] = $tags;
        }

        if ($metadata !== null) {
            $action['metadata'] = $metadata;
        }

        if ($rotate) {
            $action['rotate'] = $rotate;
        }

        if ($resize) {
            $action['resize'] = $resize;
        }

        if ($crop) {
            $action['crop'] = $crop;
        }

        if ($rotate || $resize || $crop) {
            if ($quality) {
                $action['quality'] = $quality;
            }
        }

        return $this->addAction($action);
    }

    /**
     * Get image
     *
     * @param string $id Image ID
     * @return string Binary image contents
     * @throws HttpException
     */
    public function imageGet($id)
    {
        return $this->_conn->request(json_encode([[
            'action' => 'image-get',
            'id'     => $id,
        ]]));
    }

    /**
     * Get image info
     *
     * @param string $id Image ID
     * @return Action The action object
     */
    public function imageInfo($id)
    {
        return $this->addAction([
            'action' => 'image-info',
            'id'     => $id,
        ]);
    }

    /**
     * Remove image
     *
     * @param string $id Image ID
     * @return Action The action object
     */
    public function imageRemove($id)
    {
        return $this->addAction([
            'action' => 'image-remove',
            'id'     => $id,
        ]);
    }

    /**
     * Find images matching the giver criteria
     *
     * @param string|array $album Filter by album
     * @param string|array $format Filter by image format (jpg / png).
     * @param string|array $width Filter by width
     * @param string|array $height Filter by height
     * @param string|array $filesize Filter by filesize
     * @param boolean $public Filter by "public" flag
     * @param string|array $tags Filter by image tags
     * @param string|array Filter by image creation time
     * @param integer $offset Skip first {offset} images in results
     * @param integer $limit Return no more than {limit} images in result
     * @return Action The action object
     */
    public function imageSearch($album = null, $format = null, $width = null, $height = null, $filesize = null, $public = null, $tags = null, $created = null, $offset = 0, $limit = 100)
    {
        $action = [
            'action' => 'image-search',
        ];

        $params = [
            'album',
            'format',
            'width',
            'height',
            'filesize',
            'public',
            'tags',
            'created',
            'offset',
            'limit',
        ];

        foreach ($params as $param) {
            if ($$param !== null) {
                $action[$param] = $$param;
            }
        }

        return $this->addAction($action);
    }

    /**
     * Get job status and result when job is done
     *
     * @param string $id Job ID
     * @return Action The action object
     */
    public function jobView($id)
    {
        return $this->addAction([
            'action' => 'job-view',
            'id'     => $id,
        ]);
    }

    /**
     * Adds action to list of actions to perform during next API call
     *
     * @param array $params Action params
     * @return Action The action object
     */
    public function addAction($params)
    {
        $id = count($this->_actions) + 1;
        return $this->_actions[$id] = new Action($id, $params);
    }

    /**
     * Clear actions and results
     */
    public function clear()
    {
        $this->_actions = [];
        $this->_results = [];
        $this->_wait = [];
    }

    /**
     * Makes API call
     *
     * @param boolean $wait Wait for all asynchronous actions to be completed
     * @param integer $delay Number of microseconds to wait before next request
     * @return array List of performed actions
     * @throws Exception on connection or API error
     */
    public function run($wait = false, $delay = 1000000)
    {
        $response = $this->_conn->request($this->_prepareRequest($this->_actions));

        try {
            $results = json_decode($response, true);
        } catch (\Exception $e) {
            throw new ApiException('Malformed server response');
        }

        $actions = [];

        foreach ($results as $k => $result) {
            $id = $k + 1;
            $action = $this->_actions[$id];
            if ($action->getParams()['action'] == 'image-create' && $result['success'] && $wait) {
                $action->setParams([
                    'action' => 'job-view',
                    'id'     => $result['result']['job'],
                ]);
                $this->_wait[] = $action;
            } else {
                $action->setResult($result);
                $this->_results[] = $action;
                $actions[] = $action;
            }
        }

        $this->_actions = [];

        while ($wait && $this->_wait !== []) {
            $response = $this->_conn->request($this->_prepareRequest($this->_wait));
            try {
                $results = json_decode($response, true);
            } catch (\Exception $e) {
                if ($e->getCode() == 429) {
                    throw $e;
                }
            }

            $rearrange = false;

            foreach ($results as $k => $result) {
                $action = $this->_wait[$k];
                if ($result['done']) {
                    $action->setResult($result);
                    unset($this->_wait[$k]);
                    $rearrange = true;
                    $this->_results[] = $action;
                    $actions[] = $action;
                }
            }

            if ($rearrange) {
                $this->_wait = array_values($this->_wait);
            }

            usleep($delay);
        }

        return $actions;
    }

    /**
     * Encodes list of actions with JSON
     *
     * @param array $actions List of actions
     * @return string JSON-encoded string
     */
    protected function _prepareRequest($actions)
    {
        return json_encode(array_map(function($action) {
            return $action->getParams();
        }, array_values($actions)));
    }
}
