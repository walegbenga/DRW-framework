<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 07/04/20
* Time : 11:50
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

class DestroyDb extends Command
{
	protected function configure()
	{
		$this->setName('destroy:db')
		->setDescription('This action destroy database.')
		->setHelp("Use this command to destroy a database.")
		->addArgument('db', InputArgument::REQUIRED, "Database");
		#->addOption('column', null, InputOption::VALUE_REQUIRED, "");
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Some imaginary logic here...
		include __DIR__ . '/../../../Generic/Database/includes/DatabaseConnection.php';
		$ga = new GenerateDBModel($pdo);
		#$this->gc->generateController($input->getArgument('table'));
		$ga->dropDb($input->getArgument("db"));
		#$input->getArgument("table");
		$output->writeln('Database destroyed.');

		return 0;
	}
}