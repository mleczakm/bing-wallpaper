<?php
/**
 * Created by PhpStorm.
 * User: mleczakm
 * Date: 04.05.17
 * Time: 00:23
 */

namespace AppBundle\Wallpaper;


class UrlProvider
{
    private $resolutions = [
        '1366×768', '1920×1080', '1920×1200'
    ];

    private $imageUri = 'http://www.bing.com/%s_%s.jpg';

    public function generateUrl(Image $image, $resolution)
    {
        return sprintf($this->imageUri, ltrim($image->getBaseUrl(),"/"), $resolution);
    }
}
