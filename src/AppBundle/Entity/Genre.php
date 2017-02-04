<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 14/12/2016
 * Time: 09:38
 */

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     attributes={
 *          "filters"={"label.order", "label.filter"},
 *          "pagination_enabled"=false,
 *          "normalization_context"={"groups"={"get"}},
 *          "itemOperations"={
 *              "get"={"method"="GET", "normalization_context"={"groups"={"get"}}}
 *          },
 *          "collectionOperations"={
 *              "get"={"method"="GET", "normalization_context"={"groups"={"get"}}}
 *          }
 *      }
 * )
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
     * @Groups({"get"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Groups({"get"})
     */
    private $label;

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
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return Genre
     */
    public function setLabel($label)
    {
        $this->label = $label;

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
