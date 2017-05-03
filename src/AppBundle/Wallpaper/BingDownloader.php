<?php
/**
 * Created by PhpStorm.
 * User: mleczakm
 * Date: 03.05.17
 * Time: 22:34
 */

namespace AppBundle\Wallpaper;


use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Http\Message\MessageFactory\GuzzleMessageFactory;

class BingDownloader
{
    private $markets = [
        'en-US',
        'zh-CN',
        'ja-JP',
        'en-AU',
        'en-UK',
        'de-DE',
        'en-NZ',
    ];

    /**
     * @var HttpClient
     */
    private $httpClient;
    /**
     * @var MessageFactory
     */
    private $messageFactory;

    public function __construct(HttpClient $httpClient)
    {

        $this->httpClient = $httpClient;
        $this->messageFactory = new GuzzleMessageFactory();
    }

    public function getDailyImage($market)
    {

        return $this->getImageForMarket($market);
    }

    private function getImageForMarket($market)
    {
        $request = $this->messageFactory->createRequest(
            'GET',
            sprintf('http://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=%s', $market)
        );

        $response = $this->httpClient->sendRequest($request);

        $imageData = json_decode((string)$response->getBody());

        $firstImageData = $imageData->images[0];

        return new Image(
            $firstImageData->url,
            $firstImageData->urlbase,
            $firstImageData->copyright,
            $firstImageData->copyrightlink
        );
    }


}
