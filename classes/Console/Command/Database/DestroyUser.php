<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 07/04/20
* Time : 11:59
*/

namespace Console\Command\Database;

use Symfony\Component\Console\{
	Command\Command,
	Input\InputInterface,
	Input\InputArgument,
	Input\InputOption,
	Output\OutputInterface
};

class DestroyUser extends Command
{
	protected function configure()
	{
		$this->setName('remove:db-user')
		->setDescription('This action destroy a database user.')
		->setHelp("Use this command to destroy a database user.")
		->addArgument('user', InputArgument::REQUIRED, "Database user");
		#->addOption('column', null, InputOption::VALUE_REQUIRED, "");
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Some imaginary logic here...
		$ga = new GenerateDBModel(include __DIR__ . '/../../includes/DatabaseConnection.php');
		#$this->gc->generateController($input->getArgument('table'));
		$ga->destroyAdmin($input->getArgument("user"));
		#$input->getArgument("table");
		$output->writeln('Database user remove.');

		return 0;
	}
}