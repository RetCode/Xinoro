<?php

    namespace app\core;

use Exception;

    // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    const HOST = "localhost";
    const USER = "root";
    const PASSWORD = "root";
    const BASENAME = "polandshop";
    const PORT = "3306";

    /* База данных  */
    /* by xoheveras */
    class DataBase
    {
        public static function connect() { return mysqli_connect(HOST, USER, PASSWORD, BASENAME, PORT); }

        public static function Query($query)
        {
            try
            {
                $mysqlconnect = DataBase::connect();
                if($requst = mysqli_query($mysqlconnect, $query))
                {
                    $result = mysqli_fetch_assoc($requst);
                    mysqli_free_result($requst);
                    $mysqlconnect->close();
                    return $result;
                }
                else
                    return null;
            }
            catch(Exception $ex)
            {
                return null;
            }
        }

        public static function QueryAll($query)
        {
            try
            {
                $mysqlconnect = DataBase::connect();
                $requst = mysqli_query($mysqlconnect, $query);
                $rows = mysqli_fetch_all($requst,MYSQLI_ASSOC);
                return $rows;
            }
            catch(Exception $ex)
            {
                return null;
            }
        }

        
        public static function QueryUpd($query)
        {
            try
            {
                $mysqlconnect = DataBase::connect();
                $mysqlconnect->query($query);
                $mysqlconnect->close();
            }
            catch(Exception $ex)
            {
                return null;
            }
        }
    }