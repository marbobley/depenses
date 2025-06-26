<?php

namespace App\Tests\Controller;

use App\Tests\Controller\ResponseIsSuccessful\ConnectUserToPage;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AllAdminRouteTest extends WebTestCase
{
    private static string $user = 'Admin';

    public function testAppAdminCategoryIndex(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/category/', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAppAdminCategoryNew(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/category/new', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAppAdminDepenseIndex(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/depense/', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAppAdminDepenseNew(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/depense/new', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAppAdminFamilyIndex(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/family/', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAppAdminFamilyNew(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/family/new', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAppUserProfilIndex(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/user/profil/', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAppUserProfilNew(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/admin/user/profil/new', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAppCategoryIndex(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/category/', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAppCategoryNew(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/category/new', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAppDepenseIndex(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAppDepenseNew(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/new', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAppDepenseSearch(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/search', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAppChartDepense(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/depense/report', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAppDepenseChartjs(): void
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

    public function testAppFamilyJoinIndex(): void
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

    public function testAppFamilyPasswordIndex(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/family/password', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAppMain(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage('GET', 'http://127.0.0.1:8000/', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
