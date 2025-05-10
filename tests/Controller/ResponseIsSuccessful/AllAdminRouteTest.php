<?php

namespace App\Tests\Controller;

use App\Tests\Controller\ResponseIsSuccessful\ConnectUserToPage;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AllAdminRouteTest extends WebTestCase
{
    private static string $adminUser = 'admin';

    public function testappAdminCategoryIndex(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/category/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testappAdminCategoryNew(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/category/new', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testappAdminDepenseIndex(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/depense/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testappAdminDepenseNew(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/depense/new', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testappAdminFamilyIndex(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/family/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testappAdminFamilyNew(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/family/new', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testappUserProfilIndex(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/user/profil/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testappUserProfilNew(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/user/profil/new', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testappCategoryIndex(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/category/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testappCategoryNew(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/category/new', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testappDepenseIndex(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testappDepenseNew(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/new', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testappDepenseSearch(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/search', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testappChartDepense(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/report', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testappDepenseChartjs(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/chartjs', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testappFamilyNew(): void
    {
        // $this->expectException(AccessDeniedHttpException::class);

        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/family/new', self::$adminUser);

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    public function testappFamilyJoinIndex(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/family/join', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testappFamilyLeave(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/family/leave', self::$adminUser);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testappFamilyPasswordIndex(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/family/password', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testappMain(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
