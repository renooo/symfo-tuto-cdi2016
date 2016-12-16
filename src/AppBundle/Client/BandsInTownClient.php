<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 15/12/2016
 * Time: 09:42
 */

namespace AppBundle\Client;


use AppBundle\Entity\Artist;
use GuzzleHttp\Client;

class BandsInTownClient
{
    /**
     * @var string
     */
    private $appId;

    /**
     * @var Client
     */
    private $guzzle;

    function __construct($appId, Client $guzzle)
    {
        $this->appId = $appId;
        $this->guzzle = $guzzle;
    }

    public function getTourDates(Artist $artist)
    {
        $url = sprintf('/artists/%s/events.json', $artist->getName());

        try {
            $response = $this->guzzle->get($url, [
                'query' => ['api_version' => '2.0', 'app_id' => $this->appId],
            ]);

            $tourDates = json_decode((string) $response->getBody());

        } catch (\Exception $e) {
            $tourDates = [];
        }

        return $tourDates;
    }
}
