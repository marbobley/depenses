<?php

namespace App\Tests\Controller\ResponseIsSuccessful;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConnectUserToPage extends WebTestCase
{
    /**
     * Connect $user with given $method (GET, POST) to $url.
     */
    public static function ConnectUserToPage(string $method, string $url, string $user): KernelBrowser
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $currentUser = $userRepository->findOneBy(['username' => $user]);

        // simulate $testUser being logged in
        $client->loginUser($currentUser);

        // test e.g. the profile page
        $client->request($method, $url);

        return $client;
    }
}
