<?php
namespace Console\Command\Controller;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Generic\Console\Controller\GenerateController;
use Generic\Console\ControllerAPI\GenerateControllerAPI;

class CreateController extends Command
{
    /*private $gc;

    public function __construct(GenerateController $gc)
    {
        $this->gc = $gc;
        parent::_construct();
    }*/
    
    protected function configure()
    {
        $this->setName('create:controller')
        ->setDescription('New controller about to be generated.')
        ->setHelp("Use this command to generate a new controller.")
        ->addArgument('name', InputArgument::REQUIRED, "Controller name")
        ->addOption('api', null, InputOption::VALUE_OPTIONAL);
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Some imaginary logic here...
        $gc = new GenerateController();
        $api = new GenerateControllerAPI();
        #$this->gc->generateController($input->getArgument('name'));
        $gc->generateController($input->getArgument("name"));
        
        // Getting the controller name to be use if api value is not set
        $value = null;

        if ($input->hasParameterOption('--api')) {
            $value = $input->getParameterOption('--api')!= null ? $input->getOption('api') : $input->getArgument("name");
        }

        $api->generateControllerAPI($value);
        
        #$input->getArgument("name");
        $output->writeln('Controller created.');

        return 0;
    }
}
