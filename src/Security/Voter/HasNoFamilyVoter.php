<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class HasNoFamilyVoter extends Voter
{
    public const HASNOFAMILY = 'hasNoFamily';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::HASNOFAMILY])) {
            return false;
        }

        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        return $this->hasNoFamily($user);
    }

    private function hasNoFamily(User $user): bool
    {
        // this assumes that the Post object has a `getOwner()` method
        $family = $user->getFamily();
        if (null === $family) {
            return true;
        }

        return false;
    }
}
