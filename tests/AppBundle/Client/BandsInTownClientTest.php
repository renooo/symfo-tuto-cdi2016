<?php

/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 15/12/2016
 * Time: 16:39
 */
class BandsInTownClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \AppBundle\Client\BandsInTownClient::getTourDates
     */
    public function getTourDatesReturnsTourDatesForExistingArtist()
    {
        $mockDates = [
            ['id' => 1, 'title' => 'Super concert', 'datetime' => date('Y-m-d')],
            ['id' => 2, 'title' => 'Super festoche', 'datetime' => date('Y-m-d')],
            ['id' => 3, 'title' => 'Gigateuf', 'datetime' => date('Y-m-d')],
        ];

        $mock = new \GuzzleHttp\Handler\MockHandler([
            new \GuzzleHttp\Psr7\Response(200, [], json_encode($mockDates)),
        ]);

        $handler = \GuzzleHttp\HandlerStack::create($mock);


        $appId = 'tuto_phpunit';
        $guzzle = new \GuzzleHttp\Client(['handler' => $handler]);
        $client = new \AppBundle\Client\BandsInTownClient($appId, $guzzle);

        $this->assertInstanceOf(\AppBundle\Client\BandsInTownClient::class, $client);

        $artist = new \AppBundle\Entity\Artist();
        $artist->setName('Aerosmith');

        $tourDates = $client->getTourDates($artist);

        $this->assertInternalType('array', $tourDates);
        $this->assertNotEmpty($tourDates);
    }

    /**
     * @test
     * @covers \AppBundle\Client\BandsInTownClient::getTourDates
     */
    public function getTourDatesReturnsEmptyArrayForUnknownArtist()
    {
        $mockDates = [];

        $mock = new \GuzzleHttp\Handler\MockHandler([
            new \GuzzleHttp\Psr7\Response(404, [], json_encode($mockDates)),
        ]);

        $handler = \GuzzleHttp\HandlerStack::create($mock);


        $appId = 'tuto_phpunit';
        $guzzle = new \GuzzleHttp\Client(['handler' => $handler]);
        $client = new \AppBundle\Client\BandsInTownClient($appId, $guzzle);

        $this->assertInstanceOf(\AppBundle\Client\BandsInTownClient::class, $client);

        $artist = new \AppBundle\Entity\Artist();
        $artist->setName('Maitre Gimms');

        $tourDates = $client->getTourDates($artist);

        $this->assertInternalType('array', $tourDates);
        $this->assertEmpty($tourDates);
    }
}
