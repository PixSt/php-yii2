<?php
/**
 * @link https://pix.st/
 * @copyright Copyright (c) 2015 Pix Street
 * @license MIT License https://opensource.org/licenses/MIT
 */

namespace pixst;

use pixst\ChannelInterface;
use pixst\exceptions\ChannelException;
use pixst\exceptions\HttpException;

/**
 * cURL channel class
 */
class CurlChannel implements ChannelInterface
{
    /**
     * @var resource $_ch cURL handle
     */
    protected $_ch;

    /**
     * Constructor
     *
     * @param string $url Pix Street API endpoint URL
     */
    public function __construct()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $this->_ch = $ch;
    }

    /**
     * Sets Pix Street API endpoint URL
     *
     * @param string $url Pix Street API endpoint URL
     * @return ChannelInterface Channel object itsel
     */
    public function setUrl($url) {
        curl_setopt($this->_ch, CURLOPT_URL, $url);

        return $this;
    }

    /**
     * Sets additional request headers
     *
     * @param array $headers List of additional request headers
     * @return CurlChannel Channel object itsel
     */
    public function setHeaders($headers)
    {
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array_map(
            function($name, $value) {
                return $name . ': ' . $value;
            },
            array_keys($headers),
            array_values($headers)
        ));

        return $this;
    }

    /**
     * Sets POST-request's body
     *
     * @param string $body POST-request's body
     * @return CurlChannel Channel object itself
     */
    public function setBody($body)
    {
        curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $body);

        return $this;
    }

    /**
     * Executes cURL session
     *
     * @return string Pix Street API response
     * @throws Exception on connection or API error
     */
    public function query()
    {
        $response = curl_exec($this->_ch);

        if (curl_error($this->_ch)) {
            throw new ChannelException;
        }

        $httpCode = curl_getinfo($this->_ch, CURLINFO_HTTP_CODE);

        switch ($httpCode) {
            case 200:
                return $response;
            case 400:
                throw new HttpException($response, $httpCode);
            case 401:
                throw new HttpException($response, $httpCode);
            case 404:
                throw new HttpException('Not Found', $httpCode);
            case 429:
                throw new HttpException('Too Many Requests', $httpCode);
            case 500:
                throw new HttpException('Internal Server Error', $httpCode);
            case 502:
                throw new HttpException('Bad Gateway', $httpCode);
            case 504:
                throw new HttpException('Gateway Timeout', $httpCode);
            default:
                throw new HttpException('Unknown Error', $httpCode);
        }

        return $response;
    }
}
