<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 06/04/20
* Time : 07:46
*/
namespace Console\Command\Controller;

use Symfony\Component\Console\{
    Command\Command,
    Input\InputInterface,
    Input\InputArgument,
    Input\InputOption,
    Output\OutputInterface
};
use Generic\Console\Controller\GenerateController;


class DestroyController extends Command
{
	protected function configure()
	{
		$this->setName('destroy:controller')
        ->setDescription('This command is use to destroy or delete a controller.')
        ->setHelp("Use this command to destroy a controller.")
        ->addArgument('name', InputArgument::REQUIRED, 'Controller name.');
        #->addArgument('dir', InputArgument::OPTIONAL, "Controller name to destroy.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Some imaginary logic here...
        $gc = new GenerateController();
        #$this->gc->generateController($input->getArgument('name'));
        $gc->delController($input->getArgument("name"));
        #$input->getArgument("name");
        $output->writeln('Controller destroyed.');

        return 0;
    }
}