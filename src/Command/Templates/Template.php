<?php

namespace App\Command\Templates;

class Template
{
    public static function ClassTestName(string $name): string
    {
        return str_replace('{name}', ucfirst($name), 'All{name}RouteTest.php');
    }

    public static function TemplateClassTest(string $userName): string
    {
        $template = '<?php

namespace App\Tests\Controller;

use App\Tests\Controller\ResponseIsSuccessful\ConnectUserToPage;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class All{userName}RouteTest extends WebTestCase
{
    private static string $user = \'{userName}\';
    {methods}
}';

        return str_replace('{userName}', ucfirst($userName), $template);
    }

    public static function TemplateAssertIsSuccessFul(string $name, string $path): string
    {
        $template = 'public function test_{name}(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage(\'GET\', \'http://127.0.0.1:8000{path}\', self::$user);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    ';

        return str_replace('{name}', $name, str_replace('{path}', $path, $template));
    }

    public static function TemplateConnectToUserPage(): string
    {
        return '<?php
namespace App\Tests\Controller\ResponseIsSuccessful;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConnectUserToPage extends WebTestCase {

/**
 * Connect $user with given $method (GET, POST) to $url.
 */
public static function ConnectUserToPage(string $method, string $url, string $user): KernelBrowser
{
    $client = static::createClient();
    $userRepository = static::getContainer()->get(UserRepository::class);

    // retrieve the test user
    $currentUser = $userRepository->findOneBy([\'username\' => $user]);

    // simulate $testUser being logged in
    $client->loginUser($currentUser);

    // test e.g. the profile page
    $client->request($method, $url);

    return $client;
}
}';
    }
}
