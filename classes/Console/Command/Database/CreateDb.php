<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 07/04/20
* Time : 08:18
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

class CreateDb extends Command
{
	protected function configure()
	{
		$this->setName('create:db')
		->setDescription('This action generate the database.')
		->setHelp("Use this command to generate a database.")
		->addArgument('db', InputArgument::REQUIRED, "Database")
		->addOption('user', null, InputOption::VALUE_REQUIRED, "secret")
		->addOption('pw', null, InputOption::VALUE_REQUIRED, "secret");
	}
	
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Some imaginary logic here...
		include __DIR__ . '/../../../Generic/Database/includes/DatabaseConnection.php';
		$ga = new GenerateDBModel($pdo);
		#$this->gc->generateController($input->getArgument('table'));
		$ga->createDb($input->getArgument("db"), $input->getOption("user"), $input->getOption("pw"));
		#$input->getArgument("table");
		$output->writeln('Database created.');

		return 0;
	}
}