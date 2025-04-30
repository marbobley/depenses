<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'make:TestRouteAdmin')]
class TestRouteAdminCommand extends Command
{
    protected function configure(): void
    {
        $this
            // the command description shown when running "php bin/console list"
            ->setDescription('Generate PhpUnit test')
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to generate phpUnit test for all your routes...')
            ->addArgument('show', InputArgument::OPTIONAL, 'Show all route take in account')
        ;
    }

    private static function TemplateClassTest() : string 
    {
        return '<?php

namespace App\Tests\Controller;

use App\Tests\Controller\ResponseIsSuccessful\ConnectUserToPage;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AllAdminRouteTest extends WebTestCase
{
    private static string $adminUser = \'admin\';
    {methods}
}';
    }

    private static function TemplateAssertIsSuccessFul(string $name, string $path) : string
    {
        $template = 'public function test_{name}(): void
    {
        $client = ConnectUserToPage::ConnectUserToPage(\'GET\', \'http://127.0.0.1:8000{path}\', self::$adminUser);

        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    ';
       return str_replace('{name}', $name, str_replace('{path}', $path , $template));       
    }

    private static function TemplateConnectToUserPage() : string 
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

    protected function execute(InputInterface $input, OutputInterface $outputInterface): int
    {
        $output = null;
        $cmdLists = null;
        exec('php bin/console debug:route ', $cmdLists, $output);

        if($input->getArgument('show'))
        {
            foreach($cmdLists as $cmd)
            {
                if(str_contains( $cmd,'GET') && !str_contains($cmd,'{'))
                {
                    $outputInterface->writeln($cmd); 
                }          
            }
            return Command::SUCCESS;
        }

        $output = null;
        $cmdLists = null;
        exec('php bin/console debug:route ', $cmdLists, $output);

        $path = '/home/nora/Documents/Projects/depenses/tests/Controller/ResponseIsSuccessful/';

        $myfile = fopen($path . "ConnectUserToPage.php", "w") ;
        fwrite($myfile, self::TemplateConnectToUserPage());
        fclose($myfile);


        $myfile2 = fopen($path . "AllAdminRouteTest.php", "w") ;
        $methods = '';
        foreach($cmdLists as $cmd)
        {
            if(str_contains( $cmd,'GET') && !str_contains($cmd,'{'))
            {
                $arr = preg_split('/\s+/', $cmd);
                $methods = $methods . self::TemplateAssertIsSuccessFul($arr[1],$arr[5]);  
            }          
        }

        $res = str_replace('{methods}' , $methods , self::TemplateClassTest());
        fwrite($myfile2, $res);
        fclose($myfile2);

        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}
