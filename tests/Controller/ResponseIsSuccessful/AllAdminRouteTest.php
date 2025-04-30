<?php

namespace App\Tests\Controller;

use App\Tests\Controller\ResponseIsSuccessful\ConnectUserToPage;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AllAdminRouteTest extends WebTestCase
{
    private static string $adminUser = 'admin';
    public function testapp_admin_category_index(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/category/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testapp_admin_category_new(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/category/new', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testapp_admin_depense_index(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/depense/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testapp_admin_depense_new(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/depense/new', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testapp_admin_family_index(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/family/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testapp_admin_family_new(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/family/new', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testapp_user_profil_index(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/user/profil/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testapp_user_profil_new(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/user/profil/new', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testapp_category_index(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/category/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testapp_category_new(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/category/new', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testapp_depense_index(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testapp_depense_new(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/new', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testapp_depense_search(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/search', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testapp_chart_depense(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/report', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testapp_depense_chartjs(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/chartjs', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

   /* public function testapp_family_new(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/family/new', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }*/

    public function testapp_family_join_index(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/family/join', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /*public function testapp_family_leave(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/family/leave', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }*/

    public function testapp_family_password_index(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/family/password', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testapp_main(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    
}