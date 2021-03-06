<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 13/12/2016
 * Time: 11:40
 */

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     attributes={
 *          "filters"={"name.order", "artist.genre", "name.filter"},
 *          "normalization_context"={"groups"={"get", "cget"}},
 *          "itemOperations"={
 *              "get"={"method"="GET", "normalization_context"={"groups"={"get"}}}
 *          },
 *          "collectionOperations"={
 *              "get"={"method"="GET", "normalization_context"={"groups"={"cget"}}}
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArtistRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Artist
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"get", "cget"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\Length(min="3")
     * @Groups({"get", "cget"})
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Assert\Range(min="1900")
     * @Groups({"get", "cget"})
     */
    private $creationYear;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Album", mappedBy="artist", cascade={"all"})
     * @Groups({"get"})
     */
    private $albums;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Genre", inversedBy="artists", fetch="EAGER")
     * @Groups({"get", "cget"})
     */
    private $genres;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="submittedArtists", fetch="EAGER")
     * @Groups({"get"})
     */
    private $submittedBy;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"get", "cget"})
     */
    private $biography;


    function __construct()
    {
        $this->albums = new ArrayCollection();
        $this->genres = new ArrayCollection();
    }

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
    public function getCreationYear()
    {
        return $this->creationYear;
    }

    /**
     * @param int $creationYear
     * @return Artist
     */
    public function setCreationYear($creationYear)
    {
        $this->creationYear = $creationYear;

        return $this;
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
     * @return Artist
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Album[]
     */
    public function getAlbums()
    {
        return $this->albums;
    }

    /**
     * @param Album[] $albums
     * @return Artist
     */
    public function setAlbums($albums)
    {
        $this->albums = $albums;

        return $this;
    }

    public function addAlbum(Album $album)
    {
        $album->setArtist($this);
        $this->albums->add($album);
    }

    /**
     * @return Genre[]
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * @param Genre[] $genres
     * @return Artist
     */
    public function setGenres($genres)
    {
        $this->genres = $genres;

        return $this;
    }

    /**
     * @param Genre $genre
     */
    public function addGenre(Genre $genre)
    {
        $this->genres->add($genre);
    }

    /**
     * @param Genre $genre
     */
    public function removeGenre(Genre $genre)
    {
        $this->genres->remove($genre);
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateName()
    {
    }

    /**
     * @return User
     */
    public function getSubmittedBy()
    {
        return $this->submittedBy;
    }

    /**
     * @param User $submittedBy
     * @return Artist
     */
    public function setSubmittedBy($submittedBy)
    {
        $this->submittedBy = $submittedBy;

        return $this;
    }

    /**
     * @return string
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * @param string $biography
     * @return Artist
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;

        return $this;
    }

    protected function calculateSuggestWeight()
    {
        $weight = 0;

        if (!empty($this->biography)) {
            $weight += 5;
        }

        if ($this->getAlbums()->count() > 0) {
            $weight += 5;
        }

        return $weight;
    }

    public function getSuggest()
    {
        return [
            'weight' => $this->calculateSuggestWeight(),
            'input' => array_merge(
                [
                    $this->getName(),
                    (string) $this->getCreationYear(),
                ],
                []
//                $this->getGenres()->map(function(Genre $g){
//                    return $g->getName();
//                })->toArray()
            ),
            'contexts' => [
                'genre' => $this->getGenres()->map(function(Genre $g){ return $g->getLabel(); })->toArray()
            ]
        ];
    }

    /**
     * @return int
     */
    public function getAlbumCount()
    {
        return $this->getAlbums()->count();
    }

    /**
     * @return string[]
     */
    public function getGenreLabels()
    {
        return $this->getGenres()->map(function(Genre $g){ return $g->getLabel(); });
    }
}
