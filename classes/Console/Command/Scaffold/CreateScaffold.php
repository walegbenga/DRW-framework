<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 07/04/20
* Time : 08:06
*/

namespace Console\Command\Scaffold;

use Generic\Console\Scaffold\GenerateScaffold;

/*use Console\Command\{
	Controller\CreateController,
	ControllerAPI\CreateControllerApi,
	Database\CreateTable,
	Database\CreateAdmin,

};*/

use Symfony\Component\Console\{
	Command\Command,
	Input\InputInterface,
	Input\InputArgument,
	Input\InputOption,
	Input\ArrayInput,
	Output\OutputInterface
};

class CreateScaffold extends Command
{
	protected function configure()
	{
		$this->setName('generate:scaffold')
		->setDescription('This action generate a starting template.')
		->setHelp("Use this command to generate a starting template.")
		->addArgument('table', InputArgument::REQUIRED, "Database table")
		->addArgument('column', InputArgument::IS_ARRAY, "Table column")
		->addOption('cache', null, InputOption::VALUE_REQUIRED, "false");
	}
	
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Some imaginary logic here...
		$scaffold = new GenerateScaffold();
		#$this->gc->generateController($input->getArgument('table'));
		$scaffold->scaffold($input->getArgument("table"), $input->getArgument("column"), $input->getOption("cache"));
		#$input->getArgument("table");
		$output->writeln('Scaffolding fully generated.');

		return 0;
	}
}