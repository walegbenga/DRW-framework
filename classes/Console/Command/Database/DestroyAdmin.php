<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 14/04/20
* Time : 12:42
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

class DestroyAdmin extends Command
{
	protected function configure()
	{
		$this->setName('destroy:admin')
		->setDescription('This action destroy admin scaffold.')
		->setHelp("Use this command to destroy a admin scaffold.")
		#->addArgument('table', InputArgument::REQUIRED, "Database table");
		->addOption('table', null, InputOption::VALUE_REQUIRED, "");
	}
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Some imaginary logic here...
		include __DIR__ . '/../../../Generic/Database/includes/DatabaseConnection.php';
		$ga = new GenerateDBModel($pdo);
		#$this->gc->generateController($input->getArgument('table'));
		$ga->dropAdmin("admin"/*$input->getOption("table")*/);
		#$input->getArgument("table");
		$output->writeln('Admin destroyed.');

		return 0;
	}
}