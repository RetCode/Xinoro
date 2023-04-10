<?php
namespace app\core;

/**
*|-----------------------------------------------------------------
*|
*|  This file is responsible for all redirects in Xinoro
*|
*|  by xoheveras
*|-----------------------------------------------------------------
**/

class Router
{
    public static function start()
    {
        $route = trim($_REQUEST['route']??'index');

        switch($route)
        {
            case "index": Router::done("index", "index"); break;
            default: Router::error(404);
        }
    }

    /**
    *|-----------------------------------------------------------------
    *|  @param string $controller - Name controller in folder
    *|  @param string $action - Name action(func) in controller(up)
    *|-----------------------------------------------------------------
    **/

    public static function done($controller,$action)
    {
        $newAction = $action."Action";
        $newController = $controller."Controller";
        require_once("app/controllers/".$newController.".php");
        $pageController = new $newController($controller, $action);
        $pageController->$newAction();
    }

    /**
    *|-----------------------------------------------------------------
    *|  @param string $code - Error code
    *|-----------------------------------------------------------------
    **/

    public static function error($code)
    {
        require_once("public/views/errors/404.php");
        exit;
    }
}