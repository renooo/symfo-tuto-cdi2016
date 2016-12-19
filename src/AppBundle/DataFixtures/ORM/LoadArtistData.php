<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 14/12/2016
 * Time: 10:07
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Artist;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadArtistData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function getOrder()
    {
        return 3;
    }

    public function load(ObjectManager $manager)
    {
        $artists = [
            [
                'name' => 'Pink Floyd',
                'creationYear' => 1965,
                'user' => 'toto',
            ],
            [
                'name' => 'Led Zeppelin',
                'creationYear' => 1968,
                'user' => 'toto',
            ],
            [
                'name' => 'Black Sabbath',
                'creationYear' => 1968,
                'user' => 'toto',
            ],
            [
                'name' => 'Rush',
                'creationYear' => 1968,
                'user' => 'toto',
            ],
            [
                'name' => 'Joy Division',
                'creationYear' => 1976,
                'user' => 'toto',
            ],
            [
                'name' => 'Love Sex Machine',
                'creationYear' => 2009,
                'user' => 'toto',
            ],
            [
                'name' => 'Dodheimsgard',
                'creationYear' => 1996,
                'user' => 'titi',
            ],
            [
                'name' => 'Slayer',
                'creationYear' => 1982,
                'user' => 'titi',
            ],
            [
                'name' => 'Enslaved',
                'creationYear' => 1992,
                'user' => 'titi',
            ],
            [
                'name' => 'Pryapisme',
                'creationYear' => 2000,
                'user' => 'titi',
            ],
            [
                'name' => 'Aerosmith',
                'creationYear' => 1970,
                'user' => 'titi',
            ],
        ];

        foreach ($artists as $artistData) {
            $artist = new Artist();
            $artist->setName($artistData['name'])
                   ->setCreationYear($artistData['creationYear']);

            $user = $this->getReference('user_'.$artistData['user']);
            $artist->setSubmittedBy($user);

            $manager->persist($artist);
            $this->addReference('artist_'.$artist->getName(), $artist);
        }

        $manager->flush();
    }
}
