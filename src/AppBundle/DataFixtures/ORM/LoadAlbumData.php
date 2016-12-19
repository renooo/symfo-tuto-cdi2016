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
        $albums = [
            [
                'title' => 'Closer',
                'releaseDate' => '1980-07-18',
                'artist' => 'Joy Division',
            ],
            [
                'title' => 'Inconnu',
                'releaseDate' => '2001-02-03',
                'artist' => 'PasDuTout',
            ],
            [
                'title' => 'Meddle',
                'releaseDate' => '1971-10-31',
                'artist' => 'Pink Floyd',
            ],
            [
                'title' => 'Dark Side Of The Moon',
                'releaseDate' => '1973-03-01',
                'artist' => 'Pink Floyd',
            ],
            [
                'title' => 'The Piper at the Gates of Dawn',
                'releaseDate' => '1967-08-05',
                'artist' => 'Pink Floyd',
            ],
        ];

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
        }

        $manager->flush();
    }
}
