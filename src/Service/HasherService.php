<?php 

namespace App\Service;

use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;

class HasherService {
    public function hash(string $plainString) : string{

        $factory = new PasswordHasherFactory(['common' => ['algorithm' => 'bcrypt']]);
        $hasher = $factory->getPasswordHasher('common');
        return $hasher->hash($plainString);
    }
} 