<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 15/12/2016
 * Time: 11:29
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use AppBundle\Event\ArtistEvent;
use AppBundle\Events\ArtistEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ArtistEventSubscriber implements EventSubscriberInterface
{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    function __construct(\Swift_Mailer $mailer, TokenStorageInterface $tokenStorage)
    {
        $this->mailer = $mailer;
        $this->tokenStorage = $tokenStorage;
    }

    public static function getSubscribedEvents()
    {
        return [
            ArtistEvents::SHOW => 'onShow',
            ArtistEvents::EDIT => 'onEdit',
        ];
    }

    public function onShow(ArtistEvent $event)
    {
        dump('Show artist : '.$event->getArtist()->getName());
    }

    public function onEdit(ArtistEvent $event)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        if (!$user || !$user->getEmailCanonical()) {
            return;
        }

        $message = \Swift_Message::newInstance()
            ->setSubject('Mise à jour de la fiche artiste')
            ->setFrom('contact@discollektor2000.com')
            ->setTo($user->getEmailCanonical())
            ->setBody(sprintf("Bonjour %s ! \nVous venez de mettre à jour l'artiste : %s", $user->getUsername(), $event->getArtist()->getName()));

        $this->mailer->send($message);
    }
}
