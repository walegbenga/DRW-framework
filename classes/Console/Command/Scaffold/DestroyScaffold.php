<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 05/05/20
* Time : 09:33
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

class DestroyScaffold extends Command
{
	protected function configure()
	{
		$this->setName('destroy:scaffold')
		->setDescription('This action destroy a generated scaffold.')
		->setHelp("Use this command to destroy a generated scaffold.")
		->addArgument('table', InputArgument::REQUIRED, "Database table");
	}
	
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Some imaginary logic here...
		$scaffold = new GenerateScaffold();
		#$this->gc->generateController($input->getArgument('table'));
		$scaffold->deScaffold($input->getArgument("table"));
		#$input->getArgument("table");
		$output->writeln('Scaffolding fully destroy.');

		return 0;
	}
}