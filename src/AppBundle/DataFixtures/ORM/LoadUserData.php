<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 18/12/2016
 * Time: 01:14
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Util\UserManipulator;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoadUserData extends AbstractFixture implements ContainerAwareInterface, FixtureInterface, OrderedFixtureInterface
{
    use ContainerAwareTrait;

    public function load(ObjectManager $manager)
    {
        $users = include 'data/users.php';

        /** @var UserManipulator $manipulator */
        $manipulator = $this->container->get('fos_user.util.user_manipulator');

        foreach ($users as $userData) {
            $user = $manipulator->create($userData['username'], $userData['password'], $userData['username'], true, false);
            $manager->persist($user);
            
            $this->setReference('user_'.$userData['username'], $user);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }

}
