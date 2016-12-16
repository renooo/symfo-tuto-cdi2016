<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 13/12/2016
 * Time: 11:40
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Track
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
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="time")
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $lyrics;

    /**
     * @var Album
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Album", inversedBy="tracks")
     */
    private $album;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param int $number
     * @return Track
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
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
     * @return Track
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param \DateTime $duration
     * @return Track
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return string
     */
    public function getLyrics()
    {
        return $this->lyrics;
    }

    /**
     * @param string $lyrics
     * @return Track
     */
    public function setLyrics($lyrics)
    {
        $this->lyrics = $lyrics;

        return $this;
    }

    /**
     * @return Album
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @param Album $album
     * @return Track
     */
    public function setAlbum($album)
    {
        $this->album = $album;

        return $this;
    }
}
