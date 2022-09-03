<?php

    use app\core\Controller;
    use app\core\DataBase;

    class indexController extends Controller
    {
        function indexAction()
        {
            $this->views->run();
        }
    }