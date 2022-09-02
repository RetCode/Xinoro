<?php

    namespace app\core;

    /* Родительский класс всех представлений */
    /* by xoheveras                          */
    class View
    {
        function __construct($Controller,$Action)
        {
            
        }

        function run($args = [])
        {
            // webGenerate - Будет подставлять значения вместо {{ name }}
        }
    }