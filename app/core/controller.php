<?php

    namespace app\core;

    /* Родительский класс всех контроллеров */
    /* by xoheveras                         */
    class Controller
    {
        protected $model;
        protected $view;

        function __construct($controller, $action)
        {
            $this->createModel($controller);
            $this->view = new View($controller, $action);
        }

        public function createModel($controller)
		{
			$model = $controller."Model";
			require_once("app/models/".$model.".php");
			$this->model = new $model($this->controller,$this->action);
		}
    }