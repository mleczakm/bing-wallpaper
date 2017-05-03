<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        /** @var  $downloader */
        $downloader = $this->get('app.wallpaper.bing_downloader');

        $image = $downloader->getDailyImage('en-US');
        $imageUri = $this->get('app.wallpaper.url_provider')->generateUrl($image, '1920x1080');

        // replace this example code with whatever you need
        return $this->render(
            'default/index.html.twig', [
                'image_uri' => $imageUri,
                'image' => $image,
            ]
        );
    }

    /**
     * @Route("/daily.jpg", name="daily")
     */
    public function dailyWallpaperAction(Request $request)
    {
        /** @var  $downloader */
        $downloader = $this->get('app.wallpaper.bing_downloader');

        $image = $downloader->getDailyImage('en-US');
        $imageUri = $this->get('app.wallpaper.url_provider')->generateUrl($image, '1920x1080');

        // replace this example code with whatever you need
        $response = new Response();
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, 'daily.jpg');
        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'image/jpeg');
        $response->setContent(file_get_contents($imageUri));
        $response->setSharedMaxAge(time() % 86400);
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }
}
