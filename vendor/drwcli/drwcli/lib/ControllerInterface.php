<?php
/**
* Created by Gbenga Ogunbule.
* User: Gbenga Ogunbule
* Date: 02/04/2020
* Time: 16:42
*/
namespace Drwcli;

use Drwcli\Command\CommandCall;

interface ControllerInterface
{
    /**
     * Called before `run`
     * @param App $app
     */
    public function boot(App $app);

    /**
     * Main execution
     * @param CommandCall $input
     */
    public function run(CommandCall $input);

    /**
     * Called when `run` is successfully finished.
     * @return void
     */
    public function teardown();
}