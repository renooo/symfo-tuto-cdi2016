<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 14/12/2016
 * Time: 11:06
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Album;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAlbumData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function getOrder()
    {
        return 4;
    }

    public function load(ObjectManager $manager)
    {
        $albums = include 'data/albums.php';

        foreach ($albums as $albumData) {
            $album = new Album();
            $album->setTitle($albumData['title'])
                  ->setReleaseDate(new \DateTime($albumData['releaseDate']));

            if (!$this->hasReference('artist_'.$albumData['artist'])) {
                continue;
            }

            $artist = $this->getReference('artist_'.$albumData['artist']);
            $album->setArtist($artist);

            $manager->persist($album);

            $this->addReference($albumData['title'], $album);
        }

        $manager->flush();
    }
}
