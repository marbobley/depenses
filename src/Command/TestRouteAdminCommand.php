<?php 

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:hello')]
class TestRouteAdminCommand extends Command
{
    protected function configure(): void
    {
        $this
            // the command description shown when running "php bin/console list"
            ->setDescription('Creates a new user.')
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to create a user...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $outputInterface): int
    {
        $output=null;
        $retval=null;
        exec('php bin/console debug:route ',$retval,$output);
        $outputInterface->writeln($retval);
        //0.  use App\Repository\UserRepository; is existing ? 

        //1. If not exists create tests folder 
        //2. If not exists create tests/Controller
        //3. If not exists create tests/Controller/ResponseIsSuccessful
        //4. If exists , delete AllAdminRouteTest.php
       
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}