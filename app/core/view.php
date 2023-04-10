<?php
namespace app\core;
use app\core\Utils;

/**
*|-----------------------------------------------------------------
*|
*|  This file contains the parent class of all views,
*|  used to launch the page and integrate variables into it.
*|
*|  by xoheveras
*|-----------------------------------------------------------------
**/

class View
{
    protected $controller;
    protected $action;

    /**
    *|-----------------------------------------------------------------
    *|  @param string $controller - Name controller in folder
    *|  @param string $action - Name action(func) in controller(up)
    *|-----------------------------------------------------------------
    **/

    function __construct($controller,$action)
    {
        $this->controller = $controller;
        $this->action = $action;
    }

    /**
    *|-----------------------------------------------------------------
    *|  @param array $args - Contains variables that will be unpacked
    *|  on the page
    *|-----------------------------------------------------------------
    **/

    function run($args = [])
    {
        extract($args);
        require_once("public/views/".$this->controller."/".$this->action.".php");
    }

    function render_html($args = [])
    {
        $style = file_get_contents("public/views/".$this->controller."/".$this->action.".php");
        echo Utils::renderHTML($style, $args);
    }
}