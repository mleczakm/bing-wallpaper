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

/*
 * 
 * 
 * #!/usr/bin/env bash
#Market options: en-US, zh-CN, ja-JP, en-AU, en-UK, de-DE, en-NZ
#Resolution options: 1366×768, 1920×1080, 1920×1200
Market="en-US"
Resolution="1920x1200"
Directory="/home/$USER/Pictures/Bing Wallpaper"
FileName="background.jpg"
ArchiveAmount=31

while ! ping -c 1 bing.com > /dev/null 2>&1; do 
        echo -e "\x1B[93m Waiting for internet connectivity to continue... \x1b[0m" 
        sleep 10; 
done; 

mkdir -pv "$Directory/archive"

URL=($(curl -s 'http://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt='"$Market" | sed -e 's/^.*"urlbase":"\([^"]*\)".*$/\1/'))
ImageURL="http://www.bing.com"/$URL"_"$Resolution".jpg"

if [ -e "$Directory/$FileName" ]
then
        fileDate=($(date -r "$Directory/$FileName" +"%Y%m%d"))
        todayDate=($(date +"%Y%m%d"))
        if [ $todayDate = $fileDate ]
        then
                echo -e "\x1B[32m You already have today's Bing image \x1b[0m";
        else
                echo -e "\x1B[32m Downloading Bing again image to: $Directory \x1b[0m";
                mv "$Directory/$FileName" "$Directory/archive/$(date +"%Y-%m-%d").jpg";
                curl -so "$Directory/$FileName" "$ImageURL";
        fi
else
        echo -e "\x1B[32m Downloading first Bing image to: $Directory \x1b[0m"
        curl -so "$Directory/$FileName" "$ImageURL"
fi

while [ ! -f "$Directory/$FileName" ]
do 
        echo -e "\x1B[93m Waiting for Bing image to finish downloading... \x1b[0m"
        sleep 10
done;

cd "$Directory/archive"
ls -t | tail -n +$((++ArchiveAmount)) | xargs -I {} rm {}

 */