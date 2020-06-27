<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 07/04/20
* Time : 11:55
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

class DestroyTable extends Command
{
	protected function configure()
	{
		$this->setName('destroy:table')
		->setDescription('This action destroy a database table.')
		->setHelp("Use this command to destroy a database table.")
		->addArgument('table', InputArgument::REQUIRED, "Databse table");
		#->addOption('column', null, InputOption::VALUE_REQUIRED, "");
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Some imaginary logic here...
		include __DIR__ . '/../../../Generic/Database/includes/DatabaseConnection.php';
		$ga = new GenerateDBModel($pdo);
		#$this->gc->generateController($input->getArgument('table'));
		$ga->dropTable($input->getArgument("table"));
		#$input->getArgument("table");
		$output->writeln('Database table destroyed.');

		return 0;
	}
}