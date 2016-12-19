<?php

namespace AppBundle\Security;

use AppBundle\Entity\Artist;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ArtistVoter extends Voter
{
    const EDIT = 'edit';

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::EDIT))) {
            return false;
        }

        if (!$subject instanceof Artist) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Artist $post */
        $artist = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($artist, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canEdit(Artist $artist, User $user)
    {
        return $user === $artist->getSubmittedBy();
    }
}
