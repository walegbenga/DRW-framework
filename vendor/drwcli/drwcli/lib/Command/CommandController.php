<?php
/**
* Created by Gbenga Ogunbule.
* User: Gbenga Ogunbule
* Date: 01/04/2020
* Time: 20:44
*/
namespace Drwcli\Command;

use Drwcli\App;
use Drwcli\ControllerInterface;
use Drwcli\Output\CliPrinter;

abstract class CommandController implements ControllerInterface
{
    /** @var  App */
    protected $app;

    /** @var  CommandCall */
    protected $input;

    /**
     * Command Logic.
     * @return void
     */
    abstract public function handle();

    /**
     * Called before `run`.
     * @param App $app
     */
    public function boot(App $app)
    {
        $this->app = $app;
    }

    /**
     * @param CommandCall $input
     */
    public function run(CommandCall $input)
    {
        $this->input = $input;
        $this->handle();
    }

    /**
     * Called when `run` is successfully finished.
     * @return void
     */
    public function teardown()
    {
        //
    }

    /**
     * @return array
     */
    protected function getArgs()
    {
        return $this->input->args;
    }

    /**
     * @return array
     */
    protected function getParams()
    {
        return $this->input->params;
    }

    /**
     * @param string $param
     * @return bool
     */
    protected function hasParam($param)
    {
        return $this->input->hasParam($param);
    }

    /**
     * @param string $flag
     * @return bool
     */
    protected function hasFlag($flag)
    {
        return $this->input->hasFlag($flag);
    }

    /**
     * @param $param
     * @return null
     */
    protected function getParam($param)
    {
        return $this->input->getParam($param);
    }

    /**
     * @return App
     */
    protected function getApp()
    {
        return $this->app;
    }

    /**
     * @return CliPrinter
     */
    protected function getPrinter()
    {
        return $this->getApp()->getPrinter();
    }
}