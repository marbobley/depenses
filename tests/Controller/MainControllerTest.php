<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testNotConnected(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'http://127.0.0.1:8000/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Gérez vos dépenses en quelques clics !');
    }


    public function testNotConnectedAdminDepense(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'http://127.0.0.1:8000/admin/depense');

        $this->assertResponseRedirects('http://127.0.0.1:8000/login');
        $this->assertResponseStatusCodeSame(302);
    }

    public function testVisitingWhileLoggedIn(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneBy(['username' => 'user']);

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', 'http://127.0.0.1:8000/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bonjour user!!!');
    }
}
