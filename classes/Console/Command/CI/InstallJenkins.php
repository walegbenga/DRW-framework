<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 02/05/20
* Time : 09:00
*/
namespace Console\Command\CI;

use Generic\Console\CI\Install\InstallCI as ici;

use Symfony\Component\Console\{
	Command\Command,
	Input\InputInterface,
	Input\InputArgument,
	Input\InputOption,
	Output\OutputInterface
};

class InstallJenkins extends Command
{
	protected function configure()
	{
		$this->setName('install:ci-jenkins')
		->setDescription('This action install the jenkis library.')
		->setHelp("Use this command to install the jenkis library.");
		#->addArgument('column', InputArgument::IS_ARRAY|InputArgument::OPTIONAL, "Admin table");
		#->addOption('column', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, "");
	}
	
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Some imaginary logic here...
		#include __DIR__ . '/../../../Generic/Database/includes/DatabaseConnection.php';
		$ici = new ici();
		#$thici->gc->generateController($input->getArgument('table'));
		$ici->installJenkins();
		#$input->getArgument("table");
		$output->writeln('Jenkins install successfully.');

		return 0;
	}
}