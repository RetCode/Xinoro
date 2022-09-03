<?php

    namespace app\core;

    /**
    *|-----------------------------------------------------------------
    *|
    *|  This file contains the parent class of all models, used
    *|  to write functionality on the site, implementing the MVC
    *|  design method.
    *|
    *|  by xoheveras
    *|-----------------------------------------------------------------
    **/

    class Model
    {
    	protected DataBase;

        function __construct()
        {
            $this->DataBase = new DataBase();
        }
    }