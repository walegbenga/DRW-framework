<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 05/04/20
* Time : 23:03
*/

namespace Console\Command\ControllerAPI;

use Symfony\Component\Console\{
	Command\Command,
	Input\InputInterface,
	Input\InputArgument,
	Input\InputOption,
	Output\OutputInterface
};
use Generic\Console\ControllerAPI\GenerateControllerAPI;
class CreateControllerAPI extends Command
{
	protected function configure()
	{
		$this->setName('create:api')
		->setDescription('New controller api about to be generated.')
		->setHelp("Use this command to generate a new api controller.")
		->addArgument('name', InputArgument::REQUIRED, "Controller name");
	}
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Some imaginary logic here...
		$gc = new GenerateControllerAPI();
		#$this->gc->generateController($input->getArgument('name'));
		$gc->generateControllerAPI($input->getArgument("name"));
		#$input->getArgument("name");
		$output->writeln('API controller created.');

		return 0;
	}
}