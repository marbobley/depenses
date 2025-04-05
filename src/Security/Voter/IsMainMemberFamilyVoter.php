<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class IsMainMemberFamilyVoter extends Voter
{
    public const ISMAINMEMBERFAMILY = 'IsMainMemberFamily';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::ISMAINMEMBERFAMILY])) {
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
        if (!$user instanceof UserInterface) {
            return false;
        }


        return $this->IsMainMemberFamily($user);
    }

    private function IsMainMemberFamily(User $user): bool
    {
        $family = $user->getFamily();

        //If no family, user cannot be main member
        if($family === null)
            return false;

        $mainMember = $family->getMainMember();
        
        if($user === $mainMember)
            return true;


        return false;
    }
}
