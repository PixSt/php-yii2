<?php
/**
 * @link https://pix.st/
 * @copyright Copyright (c) 2015 Pix Street
 * @license MIT License https://opensource.org/licenses/MIT
 */

namespace pixst;

/**
 * ClientJson is a wrapper for Client class which forces usage of JSON for Pix Street API requests
 */
class ClientJson extends Client
{
    protected $_apiEndpoint = 'https://pix.st/2019-01-01/json';

    /**
     * Makes API call
     *
     * @param array $params action params
     * @throws Exception on connection or API error
     */
    public function execute($params)
    {
        $params = $action->getParams();

        if ($params['action'] == 'image-create') {
            if ($params['type'] == 'bytes') {
                $params['source'] = base64_encode($params['source']);
            }

            if ($params['type'] == 'file') {
                $params['type'] = 'bytes';
                $params['source'] = base64_encode(file_get_contents($params['source']));
            }
        }

        $this->_conn->setApiEndpoint($this->_apiEndpoint);

        $response = $this->_conn->post(json_encode($params));

        try {
            return json_decode($response, true);
        } catch (\Exception $e) {
            throw new ApiException('Malformed server response');
        }
    }
}
