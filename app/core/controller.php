<?php
namespace app\core;

/**
*|-----------------------------------------------------------------
*|
*|  This file contains a parent class, this class is
*|  responsible for control and quality of connections
*|  (What the user can do)
*|
*|  by xoheveras
*|-----------------------------------------------------------------
**/

class Controller
{
    protected $model;
    protected $view;
    
    /**
    *|-----------------------------------------------------------------
    *|  @param string $controller - Name controller in folder
    *|  @param string $action - Name action(func) in controller(up)
    *|-----------------------------------------------------------------
    **/

    function __construct($controller, $action)
    {
        $this->createModel($controller);
        $this->view = new View($controller, $action);
    }

    /**
    *|-----------------------------------------------------------------
    *|  @param string $controller - Name controller in folder
    *|-----------------------------------------------------------------
    **/

    public function createModel($controller)
    {
        $model = $controller."Model";
        require_once("app/models/".$model.".php");
        $this->model = new $model($this->controller,$this->action);
    }
}