<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 24/04/20
* Time : 00:21
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

class InstallRedis extends Command
{
	protected function configure()
	{
		$this->setName('install:cache-redis')
		->setDescription('This action install the redis library.')
		->setHelp("Use this command to install the redis library.");
		#->addArgument('column', InputArgument::IS_ARRAY|InputArgument::OPTIONAL, "Admin table");
		#->addOption('column', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, "");
	}
	
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Some imaginary logic here...
		#include __DIR__ . '/../../../Generic/Database/includes/DatabaseConnection.php';
		$is = new ic();
		#$this->gc->generateController($input->getArgument('table'));
		$is->installRedis();
		#$input->getArgument("table");
		$output->writeln('Redis install successfully.');

		return 0;
	}
}