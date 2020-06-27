<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 07/04/20
* Time : 12:03
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


class DestroyModel extends Command
{
	protected function configure()
	{
		$this->setName('destroy:model')
		->setDescription('This action destroy a database model.')
		->setHelp("Use this command to destroy a database model.")
		->addArgument('file', InputArgument::REQUIRED, "Database model")
		#->addArgument('dir', InputArgument::OPTIONAL, "Database model");
		->addOption('dir', null, InputOption::VALUE_REQUIRED, "");
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Some imaginary logic here...
		include __DIR__ . '/../../../Generic/Database/includes/DatabaseConnection.php';
		$ga = new GenerateDBModel($pdo);
		#$this->gc->generateController($input->getArgument('table'));
		$ga->delModel(__DIR__ . '/../app/'/*$input->getOption("dir")*/, $input->getArgument("file"));
		#$input->getArgument("table");
		$output->writeln('Database model remove.');

		return 0;
	}
}