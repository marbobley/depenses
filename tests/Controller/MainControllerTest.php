<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testNotConnected(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'http://127.0.0.1:8000/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bienvenu sur Le bon compte');
    }

    public function testNotConnectedClickOnCommencer(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'http://127.0.0.1:8000/');

        $client->clickLink('Commencer');
        $this->assertResponseStatusCodeSame(200);
    }

    public function testNotConnectedClickOnConnexion(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'http://127.0.0.1:8000/');

        $client->clickLink('Connexion');
        $this->assertResponseStatusCodeSame(200);
    }

    public function testNotConnectedClickOnInscription(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'http://127.0.0.1:8000/');

        $client->clickLink('Inscription');
        $this->assertResponseStatusCodeSame(200);
    }

    public function testNotConnectedClickOnDepenseLogo(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'http://127.0.0.1:8000/');

        $client->clickLink('Le bon compte');
        $this->assertResponseStatusCodeSame(200);
    }

    public function testNotConnectedAdminDepense(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'http://127.0.0.1:8000/admin/depense/');

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

    public function testVisitingAdminDepenseWhileLoggedInUserRole(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneBy(['username' => 'user']);

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', 'http://127.0.0.1:8000/admin/depense/');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    public function testVisitingAdminCategoryWhileLoggedInUserRole(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneBy(['username' => 'user']);

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', 'http://127.0.0.1:8000/admin/category/');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    public function testVisitingAdminCategoryWhileLoggedInAdminRole(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneBy(['username' => 'admin']);

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', 'http://127.0.0.1:8000/admin/category/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
