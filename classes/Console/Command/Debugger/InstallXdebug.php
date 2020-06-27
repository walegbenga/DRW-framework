<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 02/05/20
* Time : 09:00
*/
namespace Console\Command\Debugger;

use Generic\Console\Debugger\Install\InstallDebugger as id;

use Symfony\Component\Console\{
	Command\Command,
	Input\InputInterface,
	Input\InputArgument,
	Input\InputOption,
	Output\OutputInterface
};

class InstallXdebug extends Command
{
	protected function configure()
	{
		$this->setName('install:debugger-xdebug')
		->setDescription('This action install the xdebug library.')
		->setHelp("Use this command to install the xdebug library.");
		#->addArgument('column', InputArgument::IS_ARRAY|InputArgument::OPTIONAL, "Admin table");
		#->addOption('column', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, "");
	}
	
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Some imaginary logic here...
		#include __DIR__ . '/../../../Generic/Database/includes/DatabaseConnection.php';
		$id = new id();
		#$thid->gc->generateController($input->getArgument('table'));
		$id->installXDebug();
		#$input->getArgument("table");
		$output->writeln('Xdebug install successfully.');

		return 0;
	}
}