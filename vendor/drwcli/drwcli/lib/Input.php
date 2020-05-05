<?php
/**
* Created by Gbenga Ogunbule.
* User: Gbenga Ogunbule
* Date: 02/04/2020
* Time: 13:14
*/
namespace Drwcli;

class Input
{
    /** @var array  */
    protected $input_history = [];

    /** @var string */
    protected $prompt;

    public function __construct($prompt = 'Drwcli$> ')
    {
        $this->setPrompt($prompt);
    }

    public function read()
    {
        $input = readline($this->getPrompt());
        $this->input_history[] = $input;

        return $input;
    }

    /**
     * @return array
     */
    public function getInputHistory()
    {
        return $this->input_history;
    }

    /**
     * @return string
     */
    public function getPrompt()
    {
        return $this->prompt;
    }

    /**
     * @param string $prompt
     */
    public function setPrompt(string $prompt)
    {
        $this->prompt = $prompt;
    }
}