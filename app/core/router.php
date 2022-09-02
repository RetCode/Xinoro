<?php

    namespace app\core;

    class Router
    {
        public static function start()
        {
            // Роутинг
        }

        /* @param $code - Принимает код ошибки, после вывидет её на экран  */
        public static function error($code)
        {
            echo "Ошибка - ".$code;
            exit;
        }
    }