<?php

    namespace app\core;

    /* Родительский класс всех представлений */
    /* by xoheveras                          */
    class View
    {
        protected $controller;
        protected $action;

        function __construct($controller,$action)
        {
            $this->controller = $controller;
            $this->action = $action;
        }

        function run($args = [])
        {
            extract($args);
            require_once("app/views/".$this->controller."/".$this->action.".php");
        }

        function preload($controller, $action, $args = [])
        {
            extract($args);
            require_once("app/views/".$controller."/".$action.".php");
        }
    }