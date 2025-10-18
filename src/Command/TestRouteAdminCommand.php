<?php

namespace App\Command;

use App\Command\Templates\Template;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
            ->addArgument('user', InputArgument::REQUIRED, 'userName : use to create route associated to that user')
            ->addOption(
                // this is the name that users must type to pass this option (e.g. --iterations=5)
                'show',
                // this is the optional shortcut of the option name, which usually is just a letter
                // (e.g. `i`, so users pass it as `-i`); use it for commonly used options
                // or options with long names
                null,
                // this is the type of option (e.g. requires a value, can be passed more than once, etc.)
                InputOption::VALUE_REQUIRED,
                // the option description displayed when showing the command help
                'Do you want to show route ?',
                // the default value of the option (for those which allow to pass values)
                0
            )
        ;
    }

    private static function Show(InputInterface $input, OutputInterface $outputInterface, array $cmdLists): int
    {
        foreach ($cmdLists as $cmd) {
            if (str_contains($cmd, 'GET') && !str_contains($cmd, '{')) {
                $outputInterface->writeln($cmd);
            }
        }

        return Command::SUCCESS;
    }

    protected function execute(InputInterface $input, OutputInterface $outputInterface): int
    {
        $output = null;
        $cmdLists = null;
        exec('php bin/console debug:route ', $cmdLists, $output);

        if ($input->getOption('show')) {
            return self::Show($input, $outputInterface, $cmdLists);
        }

        $path = '/home/nora/Documents/Projects/depenses/tests/Controller/ResponseIsSuccessful/';

        $myfile = fopen($path.'ConnectUserToPage.php', 'w');
        fwrite($myfile, Template::TemplateConnectToUserPage());
        fclose($myfile);

        $userName = $input->getArgument('user');

        $myfile2 = fopen($path.Template::ClassTestName($userName), 'w');
        $methods = '';
        foreach ($cmdLists as $cmd) {
            if (str_contains($cmd, 'GET') && !str_contains($cmd, '{')) {
                $arr = preg_split('/\s+/', $cmd);
                $methods .= Template::TemplateAssertIsSuccessFul($arr[1], $arr[5]);
            }
        }

        $res = str_replace('{methods}', $methods, Template::TemplateClassTest($userName));
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
