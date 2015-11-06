<?php
/**
 * @link https://pix.st/
 * @copyright Copyright (c) 2015 Pix Street
 * @license MIT License https://opensource.org/licenses/MIT
 */

namespace pixst;

use pixst\exceptions\ApiException;
use pixst\exceptions\HttpException;

/**
 * ClientRest is a wrapper for Client class which forces usage of REST for Pix Street API requests
 */
class ClientRest extends Client
{
    protected $_apiEndpoint = 'https://pix.st/2019-01-01/';

    /**
     * Makes API call
     *
     * @param array $params action params
     * @throws Exception on connection or API error
     */
    public function execute($action)
    {
        $params = $action->getParams();

        if ($params['action'] == 'image-create' && $params['type'] == 'file') {
            $params['source'] = new \CurlFile($params['source']);
        }

        try {
            switch ($params['action']) {
                case 'account-info':
                    $this->_conn->setApiEndpoint($this->_apiEndpoint . 'account/info');
                    $response = $this->_conn->request();
                    return json_decode($response, true);

                case 'image-create':
                    $this->_conn->setApiEndpoint($this->_apiEndpoint . 'image/create');

                    foreach ($params as $k => $v) {
                        if (is_array($v)) {
                            foreach ($v as $key => $value) {
                                $params[$k . '[' . $key . ']'] = $value;
                            }
                            unset($params[$k]);
                        }
                    }

                    $response = $this->_conn->request($params);
                    return json_decode($response, true);

                case 'image-delete':
                    $this->_conn->setApiEndpoint($this->_apiEndpoint . 'image/delete');
                    $response = $this->_conn->request($params);
                    return json_decode($response, true);

                case 'image-download':
                    $this->_conn->setApiEndpoint($this->_apiEndpoint . 'image/download');
                    return $this->_conn->request($params);

                case 'image-info':
                    $this->_conn->setApiEndpoint($this->_apiEndpoint . 'image/info');
                    $response = $this->_conn->request($params);
                    return json_decode($response, true);
            }
        } catch (HttpException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \Exception('Malformed server response');
        }
    }
}
