<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 15/12/2016
 * Time: 13:49
 */

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ApiResource()
 * @ORM\Entity()
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Artist", mappedBy="submittedBy")
     */
    private $submittedArtists;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSubmittedArtists()
    {
        return $this->submittedArtists;
    }

    /**
     * @param mixed $submittedArtists
     * @return User
     */
    public function setSubmittedArtists($submittedArtists)
    {
        $this->submittedArtists = $submittedArtists;

        return $this;
    }
}
