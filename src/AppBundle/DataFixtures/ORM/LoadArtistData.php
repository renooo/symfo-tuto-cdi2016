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
use Faker;

class LoadArtistData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function getOrder()
    {
        return 3;
    }

    public function load(ObjectManager $manager)
    {
        $artists = include 'data/artists.php';

        $userNames = ['toto', 'titi'];
        $faker = Faker\Factory::create('fr_FR');

        foreach ($artists as $artistData) {
            $artist = new Artist();
            $artist->setName($artistData['name'])
                   ->setCreationYear($artistData['creationYear'])
                   ->setBiography($faker->realText);

            $user = $this->getReference(sprintf('user_%s', $userNames[array_rand($userNames)]));
            $artist->setSubmittedBy($user);

            for ($i=0; $i<rand(1, 2); $i++) {
                $genre = $this->getReference(sprintf('genre_%s', rand(1, 148)));
                if (!$artist->getGenres()->contains($genre)) {
                    $artist->addGenre($genre);
                }
            }

            if ($this->hasReference('artist_'.$artist->getName())) {
                continue;
            }

            $manager->persist($artist);
            $this->addReference('artist_'.$artist->getName(), $artist);
        }

        $manager->flush();
    }
}
