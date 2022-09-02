<?php

    namespace application;

    require_once "vendor/autoload.php";

    use app\core\Controller;
    use app\core\Model;
    use app\core\View;
    use app\core\Router;
    use app\core\Extract;

    Router::start();
    Router::error("2020");