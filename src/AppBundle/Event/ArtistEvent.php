<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 15/12/2016
 * Time: 11:55
 */

namespace AppBundle\Event;

use AppBundle\Entity\Artist;
use Symfony\Component\EventDispatcher\Event;

class ArtistEvent extends Event
{
    /**
     * @var Artist
     */
    private $artist;

    function __construct(Artist $artist)
    {
        $this->artist = $artist;
    }

    function getArtist()
    {
        return $this->artist;
    }
}
