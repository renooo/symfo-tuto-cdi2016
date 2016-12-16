<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 14/12/2016
 * Time: 09:38
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Genre
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
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Artist", mappedBy="genres")
     */
    private $artists;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Genre
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getId3()
    {
        return ($this->getId() - 1);
    }

    /**
     * @return Artist[]
     */
    public function getArtists()
    {
        return $this->artists;
    }

    /**
     * @param Artist[] $artists
     * @return Genre
     */
    public function setArtists($artists)
    {
        $this->artists = $artists;

        return $this;
    }
}
