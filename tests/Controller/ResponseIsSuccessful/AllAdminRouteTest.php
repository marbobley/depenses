<?php

namespace App\Tests\Controller;

use App\Tests\Controller\ResponseIsSuccessful\ConnectUserToPage;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AllAdminRouteTest extends WebTestCase
{
    private static string $user = 'Admin';
    public function test_app_admin_category_index(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/category/', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_app_admin_category_new(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/category/new', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_app_admin_depense_index(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/depense/', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_app_admin_depense_new(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/depense/new', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_app_admin_family_index(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/family/', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_app_admin_family_new(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/family/new', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_app_user_profil_index(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/user/profil/', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_app_user_profil_new(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/user/profil/new', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_app_category_index(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/category/', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_app_category_new(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/category/new', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_app_depense_index(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_app_depense_new(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/new', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_app_depense_search(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/search', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_app_chart_depense(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/report', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_app_depense_chartjs(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/chartjs', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

  /*  public function test_app_family_new(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/family/new', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }*/

    public function test_app_family_join_index(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/family/join', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /*public function test_app_family_leave(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/family/leave', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }*/

    public function test_app_family_password_index(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/family/password', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_app_main(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    
}