<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AllAdminRouteTest extends WebTestCase
{
    private static string $adminUser = 'admin';

    /**
     * Connect $user with given $method (GET, POST) to $url.
     */
    public static function ConnectUserToPage(string $method, string $url, string $user): KernelBrowser
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $adminUser = $userRepository->findOneBy(['username' => $user]);

        // simulate $testUser being logged in
        $client->loginUser($adminUser);

        // test e.g. the profile page
        $client->request($method, $url);

        return $client;
    }

    public function testAdminConnected(): void
    {
        $client = self::ConnectUserToPage('GET', 'http://127.0.0.1:8000/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAdminConnectedAdminFamily(): void
    {
        $client = self::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/family/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAdminConnectedAdminFamilyAdd(): void
    {
        $client = self::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/family/new', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAdminConnectedAdminDepense(): void
    {
        $client = self::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/depense/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAdminConnectedDepenseNew(): void
    {
        $client = self::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/new', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAdminConnectedDepense(): void
    {
        $client = self::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAdminConnectedDepenseReport(): void
    {
        $client = self::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/report', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAdminConnectedAdminUser(): void
    {
        $client = self::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/user/profil/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAdminConnectedAdminCategory(): void
    {
        $client = self::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/category/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAdminConnectedAdminCategoryNew(): void
    {
        $client = self::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/category/new', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAdminConnectedCategory(): void
    {
        $client = self::ConnectUserToPage('GET', 'http://127.0.0.1:8000/category/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAdminConnectedCategoryNew(): void
    {
        $client = self::ConnectUserToPage('GET', 'http://127.0.0.1:8000/category/new', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
