<?php
/**
* Created by Gbenga Ogunbule.
* User: Gbenga Ogunbule
* Date: 02/04/2020
* Time: 11:00
*/
namespace Drwcli\Output;

use Drwcli\OutputInterface;

class BasicPrinter implements OutputInterface
{
    public function out($message)
    {
        echo $message;
    }

    public function newline()
    {
        $this->out("\n");
    }

    public function display($message)
    {
        $this->newline();
        $this->out($message);
        $this->newline();
        $this->newline();
    }
}