<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 07/04/20
* Time : 07:48
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


class DestroyControllerAPI extends Command
{
    protected function configure()
    {
        $this->setName('destroy:api')
        ->setDescription('This command is use to destroy or delete an api controller.')
        ->setHelp("Use this command to destroy an api controller.")
        ->addArgument('name', InputArgument::REQUIRED, 'Controller name.');
        #->addArgument('dir', InputArgument::OPTIONAL, "Controller name to destroy.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Some imaginary logic here...
        $gc = new GenerateControllerAPI();
        #$this->gc->generateController($input->getArgument('name'));
        $gc->delControllerApi($input->getArgument("name"));
        #$input->getArgument("name");
        $output->writeln('Api controller destroyed.');

        return 0;
    }
}