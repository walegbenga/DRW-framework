<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 07/04/20
* Time : 12:22
*/

namespace Console\Command\Database;

use Generic\Console\Database\GenerateDBModel;
use Generic\Console\Controller\GenerateController;
use Generic\Console\ControllerAPI\GenerateControllerAPI;

use Symfony\Component\Console\{
	Command\Command,
	Input\InputInterface,
	Input\InputArgument,
	Input\InputOption,
	Output\OutputInterface
};


class CreateTable extends Command
{
	protected function configure()
	{
		$this->setName('create:table')
		->setDescription('This action generate the database table.')
		->setHelp("Use this command to generate a database table.")
		->addArgument('table', InputArgument::REQUIRED, "Database table")
		->addArgument('column', InputArgument::IS_ARRAY, "Table column")
		->addOption('controller', null, InputOption::VALUE_OPTIONAL);
		#->addOption('api', null, InputOption::VALUE_OPTIONAL);
	}
	
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Some imaginary logic here...
		include __DIR__ . '/../../../Generic/Database/includes/DatabaseConnection.php';
		$ga = new GenerateDBModel($pdo);
		$gc = new GenerateController();
		$api = new GenerateControllerAPI();

		$ga->addTableToDB($input->getArgument("table"), $input->getArgument("column"));

		/*$apiValue = null;

        if ($input->hasParameterOption('--api')) {
            $apiValue = $input->getParameterOption('--api')!= null ? $input->getOption('api') : $input->getArgument("table");
        }*/

        $controllerValue = null;

        if ($input->hasParameterOption('--controller')) {
            $controllerValue = $input->getParameterOption('--controller')!= null ? $input->getOption('controller') : $input->getArgument("table");
        }
		$output->writeln($controllerValue);
		$gc->generateController($controllerValue);
		#$api->generateControllerAPI($apiValue);
		#$input->getArgument("table");
		$output->writeln('Database table created.');

		return 0;
	}
}