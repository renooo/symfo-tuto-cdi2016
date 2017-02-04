<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 14/12/2016
 * Time: 09:19
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Genre;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadGenreData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function getOrder()
    {
        return 2;
    }

    public function load(ObjectManager $manager)
    {
        $id3Tags = include 'data/genres.php';

        foreach ($id3Tags as $g => $id3Tag) {
            $genre = new Genre();
            $genre->setLabel($id3Tag);

            $manager->persist($genre);
            $this->addReference('genre_'.($g+1), $genre);
        }

        $manager->flush();
    }
}
