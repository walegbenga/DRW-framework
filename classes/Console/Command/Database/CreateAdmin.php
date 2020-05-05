<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 07/04/20
* Time : 12:11
*/
namespace Console\Command\Database;

use Generic\Console\Database\GenerateDBModel;
use Symfony\Component\Console\{
	Command\Command,
	Input\InputInterface,
	Input\InputArgument,
	Input\InputOption,
	Output\OutputInterface
};

class CreateAdmin extends Command
{
	protected function configure()
	{
		$this->setName('create:admin')
		->setDescription('This action generate admin scaffold.')
		->setHelp("Use this command to generate a admin scaffold.")
		->addArgument('column', InputArgument::IS_ARRAY|InputArgument::OPTIONAL, "Admin table");
		#->addOption('column', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, "");
	}
	
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Some imaginary logic here...
		include __DIR__ . '/../../../Generic/Database/includes/DatabaseConnection.php';
		$ga = new GenerateDBModel($pdo);
		#$this->gc->generateController($input->getArgument('table'));
		$ga->generateAdminDB($input->getArgument("column"));
		#$input->getArgument("table");
		$output->writeln('API controller created.');

		return 0;
	}
}