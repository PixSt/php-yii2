<?php
/**
 * @link https://pix.st/
 * @copyright Copyright (c) 2015 Pix Street
 * @license MIT License https://opensource.org/licenses/MIT
 */

namespace pixst;

/**
 * Channel interface that must be implemented by channel class
 */
interface ChannelInterface
{
    /**
     * Sets Pix Street API endpoint URL
     *
     * @param string $url Pix Street API endpoint URL
     * @return ChannelInterface Channel object itsel
     */
    public function setUrl($url);

    /**
     * Sets additional request headers
     *
     * @param array $headers List of additional request headers
     * @return ChannelInterface Channel object itsel
     */
    public function setHeaders($headers);

    /**
     * Sets POST-request's body
     *
     * @param string $body POST-request's body
     * @return ChannelInterface Channel object itself
     */
    public function setBody($body);

    /**
     * Executes request
     *
     * @return string Pix Street API response
     * @throws Exception on connection or API error
     */
    public function query();
}
