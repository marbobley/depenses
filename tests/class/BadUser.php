<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * Class to implement PasswordAuthenticatedUserInterface to fail to some test case.
 */
class BadUser implements PasswordAuthenticatedUserInterface
{
    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return 'bad';
    }
}
