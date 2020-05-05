<?php
/**
* Created by Gbenga Ogunbule.
* User: Gbenga Ogunbule
* Date: 02/04/2020
* Time: 09:52
*/
namespace Drwcli\Output;


class CliTheme
{
    public $styles = [];

    public function __construct(array $styles)
    {
        $this->styles = $styles;
    }

    public function __get($name)
    {
        return $this->styles[$name] ? $this->styles[$name] : null;
    }
}