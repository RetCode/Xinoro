<?php

    namespace app\core;

    const HOST = "localhost";
    const USER = "localhost";
    const PASSWORD = "localhost";
    const BASENAME = "localhost";
    const PORT = "localhost";

    /* База данных  */
    /* by xoheveras */
    class DataBase
    {
        public static function connect() { return mysqli_connect(HOST, USER, PASSWORD, BASENAME, PORT); }

        public static function QueryAll($Query)
        {
            $mysqlconnect = DataBase::connect();
        }
    }