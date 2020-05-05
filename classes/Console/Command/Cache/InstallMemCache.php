<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 20/04/20
* Time : 12:19
*/
namespace Console\Command\Cache;

use Generic\Console\Cache\Install\InstallCache as ic;

use Symfony\Component\Console\{
	Command\Command,
	Input\InputInterface,
	Input\InputArgument,
	Input\InputOption,
	Output\OutputInterface
};

class InstallMemCache extends Command
{
	protected function configure()
	{
		$this->setName('install:cache-memcache')
		->setDescription('This action install the memcache library.')
		->setHelp("Use this command to install the memcache library.");
		#->addArgument('column', InputArgument::IS_ARRAY|InputArgument::OPTIONAL, "Admin table");
		#->addOption('column', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, "");
	}
	
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Some imaginary logic here...
		#include __DIR__ . '/../../../Generic/Database/includes/DatabaseConnection.php';
		$is = new ic();
		#$this->gc->generateController($input->getArgument('table'));
		$is->installMemchached();
		#$input->getArgument("table");
		$output->writeln('Memcache install successfully.');

		return 0;
	}
}