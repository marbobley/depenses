<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

final class HasNoFamilyVoter implements VoterInterface
{
    public const HAS_NO_FAMILY = 'hasNoFamily';

    public function vote(TokenInterface $token, mixed $subject, array $attributes): int
    {
        // if the attribute isn't one we support, return ACCESS_ABSTAIN
        if (!in_array(self::HAS_NO_FAMILY, $attributes)) {
            return self::ACCESS_ABSTAIN;
        }

        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return self::ACCESS_DENIED;
        }

        return $this->hasNoFamily($user) ? self::ACCESS_GRANTED : self::ACCESS_DENIED;
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
