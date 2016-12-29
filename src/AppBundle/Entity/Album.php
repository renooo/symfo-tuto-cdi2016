<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 13/12/2016
 * Time: 11:40
 */

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity()
 */
class Album
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $releaseDate;

    /**
     * @var Track[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Track", mappedBy="album", cascade={"all"})
     */
    private $tracks;

    /**
     * @var Artist
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Artist", inversedBy="albums")
     */
    private $artist;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Album
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @param \DateTime $releaseDate
     * @return Album
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * @return Track[]
     */
    public function getTracks()
    {
        return $this->tracks;
    }

    /**
     * @param Track[] $tracks
     * @return Album
     */
    public function setTracks($tracks)
    {
        $this->tracks = $tracks;

        return $this;
    }

    /**
     * @return Artist
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param Artist $artist
     * @return Album
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;

        return $this;
    }
}
