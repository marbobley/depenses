<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class HasNoFamilyVoter extends Voter
{
    public const HAS_NO_FAMILY = 'hasNoFamily';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (self::HAS_NO_FAMILY != $attribute) {
            return false;
        }
        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
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
