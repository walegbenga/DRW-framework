<?php
/**
* Created by Gbenga Ogunbule.
* User: Gbenga Ogunbule
* Date: 02/04/2020
* Time: 15:00
*/
namespace Drwcli;


interface OutputInterface
{
    /**
     * Prints a message (no linebreak).
     * @param string $message
     * @return mixed
     */
    public function out($message);

    /**
     * Prints a line break.
     * @return void
     */
    public function newline();

    /**
     * Displays a message wrapped in new lines.
     * @param $message
     * @return void
     */
    public function display($message);
}