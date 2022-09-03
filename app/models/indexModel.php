<?php


    use app\core\DataBase;
    use app\core\Model;

    class indexModel extends Model
    {
        function indexAction()
        {
            $this->views->run();
        }
    }