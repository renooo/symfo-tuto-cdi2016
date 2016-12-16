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
        return 2;
    }

    public function load(ObjectManager $manager)
    {
        $artists = [
            [
                'name' => 'Pink Floyd',
                'creationYear' => 1965,
            ],
            [
                'name' => 'Led Zeppelin',
                'creationYear' => 1968,
            ],
            [
                'name' => 'Black Sabbath',
                'creationYear' => 1968,
            ],
            [
                'name' => 'Rush',
                'creationYear' => 1968,
            ],
            [
                'name' => 'Joy Division',
                'creationYear' => 1976,
            ],
            [
                'name' => 'Love Sex Machine',
                'creationYear' => 2009,
            ],
            [
                'name' => 'Dodheimsgard',
                'creationYear' => 1996,
            ],
            [
                'name' => 'Slayer',
                'creationYear' => 1982,
            ],
            [
                'name' => 'Enslaved',
                'creationYear' => 1992,
            ],
            [
                'name' => 'Pryapisme',
                'creationYear' => 2000,
            ],
            [
                'name' => 'Aerosmith',
                'creationYear' => 1970,
            ],
        ];

        foreach ($artists as $artistData) {
            $artist = new Artist();
            $artist->setName($artistData['name'])
                   ->setCreationYear($artistData['creationYear']);

            $manager->persist($artist);
            $this->addReference('artist_'.$artist->getName(), $artist);
        }

        $manager->flush();
    }
}
