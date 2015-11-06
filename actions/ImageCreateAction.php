<?php
/**
 * @link https://pix.st/
 * @copyright Copyright (c) 2015 Pix Street
 * @license MIT License https://opensource.org/licenses/MIT
 */

namespace pixst\actions;

class ImageCreateAction extends BaseAction
{
    protected $_name = 'image-create';

    /**
     * Sets whether to create image in asynchronous mode
     *
     * @param boolean $public whether to create image in asynchronous mode
     *
     * @return self
     */
    public function setAsync(bool $async)
    {
        $this->_params['async'] = $async;

        return $this;
    }

    /**
     * Sets crop params
     *
     * @param integer $top top coordinate
     * @param integer $left left coordinate
     * @param integer $bottom bottom coordinate
     * @param integer $right right coordinate
     *
     * @return self
     */
    public function setCrop(int $top, int $left, int $bottom, int $right)
    {
        $this->_params['crop'] = [
            'top' => $top,
            'left' => $left,
            'bottom' => $bottom,
            'right' => $right,
        ];

        return $this;
    }

    /**
     * Sets image ID
     *
     * @param string $id Unique image ID. Max length - 100 characters
     *
     * @return self
     */
    public function setID(string $id)
    {
        $this->_params['id'] = $id;

        return $this;
    }

    /**
     * Sets image metadata
     *
     * @param mixed $metadata User-defined metadata. Max length of JSON-serialized string - 5000 characters.
     *
     * @return self
     */
    public function setMetadata(array $metadata)
    {
        $this->_params['metadata'] = $metadata;

        return $this;
    }

    /**
     * Sets image name
     *
     * @param string $name Image name. Max length - 100 characters
     *
     * @return self
     */
    public function setName(string $name)
    {
        $this->_params['name'] = $name;

        return $this;
    }

    /**
     * Sets JPEG quality
     *
     * @param integer $quality JPEG quality for rotated/resized/cropped image. Possible values: 1-100. Default - 95
     *
     * @return self
     */
    public function setJpegQuality(int $quality)
    {
        $this->_params['quality'] = $quality;

        return $this;
    }

    /**
     * Sets whether to generate public URL
     *
     * @param boolean $public whether to generate public URL
     *
     * @return self
     */
    public function setPublic(bool $public)
    {
        $this->_params['public'] = $public;

        return $this;
    }

    /**
     * Sets resize params
     *
     * @param integer $width width of resized image
     * @param integer height height of resized image
     * @param boolean $keepRatio whether to keep ratio. Default - true
     *
     * @return self
     */
    public function setResize(int $width, int $height, bool $keepRatio = true)
    {
        $this->_params['resize'] = [
            'width' => $width,
            'height' => $height,
            'keepRatio' => $keepRatio,
        ];

        return $this;
    }

    /**
     * Sets rotate params
     *
     * @param integer $angle angle. Possigle values: 90, 180, 270
     * @param boolean $clockwise whether to rotate clockwize. Default - true
     *
     * @return self
     */
    public function setRotate(int $angle, bool $clockwise = true)
    {
        $this->_params['rotate'] = [
            'angle' => $angle,
            'clockwise' => $clockwise,
        ];

        return $this;
    }

    /**
     * Sets whether to shorten public URL
     *
     * @param boolean $public whether to shorten public URL
     *
     * @return self
     */
    public function setShorten(bool $shorten)
    {
        $this->_params['shorten'] = $shorten;

        return $this;
    }

    /**
     * Sets source image as binary string
     *
     * @param string $bytes binary string
     *
     * @return self
     */
    public function setSourceBytes(string $bytes)
    {
        $this->_params['type'] = 'bytes';
        $this->_params['source'] = $bytes;

        return $this;
    }

    /**
     * Sets path to source image
     *
     * @param string $source path to source image
     *
     * @return self
     */
    public function setSourceFile(string $path)
    {
        $this->_params['type'] = 'file';
        $this->_params['source'] = $path;

        return $this;
    }

    /**
     * Sets ID of source image
     *
     * @param string $id ID of source image
     *
     * @return self
     */
    public function setSourceImage(string $id)
    {
        $this->_params['type'] = 'image';
        $this->_params['source'] = $id;

        return $this;
    }

    /**
     * Sets URL of source image
     *
     * @param string $source URL of source image
     *
     * @return self
     */
    public function setSourceUrl(string $url)
    {
        $this->_params['type'] = 'url';
        $this->_params['source'] = $url;

        return $this;
    }

    /**
     * Sets tags
     *
     * @param array $tags List of tags. Max number of tags - 50. Max length of tag - 50 characters.
     *
     * @return self
     */
    public function setTags(array $tags)
    {
        $this->_params['tags'] = $tags;

        return $this;
    }
}
