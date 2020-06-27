<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 07/04/20
* Time : 07:53
*/

namespace Console\Command\Route;

use Generic\Console\Route\GenerateRoute;

use Symfony\Component\Console\{
	Command\Command,
	Input\InputInterface,
	Input\InputArgument,
	Input\InputOption,
	Output\OutputInterface
};

class CreateRoute extends Command
{
	protected function configure()
	{
		$this->setName('generate:route')
		->setDescription('This action generate the site route.')
		->setHelp("Use this command to generate the application route.")
		->addArgument('controller', InputArgument::REQUIRED, "Controller names")
		->addArgument('model', InputArgument::REQUIRED, "Model names");
		#->addOption('column', null, InputOption::VALUE_REQUIRED, "");
	}
	
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Some imaginary logic here...
		$route = new GenerateRoute();
		#$this->gc->generateController($input->getArgument('table'));
		$route->generateRoute($input->getArgument("controller"), $input->getArgument("model"));
		#$input->getArgument("table");
		$output->writeln('API controller created.');

		return 0;
	}
}