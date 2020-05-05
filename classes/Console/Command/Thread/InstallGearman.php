<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 20/04/20
* Time : 12:19
*/
namespace Console\Command\Thread;

use Generic\Console\Thread\Install\InstallGearman as gm;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InstallGearman extends Command
{
    protected function configure()
    {
        $this->setName('install:thread-gearman')
        ->setDescription('This action install the Gearman library.')
        ->setHelp("Use this command to install the Gearman library.");
        #->addArgument('column', InputArgument::IS_ARRAY|InputArgument::OPTIONAL, "Admin table");
        #->addOption('column', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, "");
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Some imaginary logic here...
        #include __DIR__ . '/../../../Generic/Database/includes/DatabaseConnection.php';
        $is = new gm();
        #$this->gc->generateController($input->getArgument('table'));
        $is->install();
        #$input->getArgument("table");
        $output->writeln('Install gearman successfully.');

        return 0;
    }
}
