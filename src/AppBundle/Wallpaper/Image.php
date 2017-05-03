<?php
/**
 * Created by PhpStorm.
 * User: mleczakm
 * Date: 04.05.17
 * Time: 00:12
 */

namespace AppBundle\Wallpaper;


class Image
{
    protected $url;
    protected $baseUrl;
    protected $copyright;
    protected $copyrightUrl;

    public function __construct(string $url, string $baseUrl, string $copyright, string $copyrightUrl)
    {
        $this->url = $url;
        $this->baseUrl = $baseUrl;
        $this->copyright = $copyright;
        $this->copyrightUrl = $copyrightUrl;
    }
    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @return mixed
     */
    public function getCopyright()
    {
        return $this->copyright;
    }

    /**
     * @return mixed
     */
    public function getCopyrightUrl()
    {
        return $this->copyrightUrl;
    }
}
