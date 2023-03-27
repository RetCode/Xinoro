<?php

    namespace app\core;
    use Exception;

    /**
    *|-----------------------------------------------------------------
    *|
    *|  This file contains the database class, contains all the
    *|  methods needed for Xinoro to work.
    *|
    *|  by xoheveras
    *|-----------------------------------------------------------------
    **/

    const HOST = "localhost";
    const USER = "root";
    const PASSWORD = "";
    const BASENAME = "XNRBOTS";
    const PORT = "3306";

    class DataBase
    {
        public static function connect() { return mysqli_connect(HOST, USER, PASSWORD, BASENAME, PORT); }

        /**
        *|-----------------------------------------------------------------
        *|  @param string $query - String query containing SQL commands
        *|
        *|  Return 1 line in query
        *|-----------------------------------------------------------------
        **/

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

        /**
        *|-----------------------------------------------------------------
        *|  @param string $query - String query containing SQL commands
        *|
        *|  Return all line in query
        *|-----------------------------------------------------------------
        **/

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

        /**
        *|-----------------------------------------------------------------
        *|  @param string $query - String query containing SQL commands
        *|
        *|  executes commands(UPDATE, INSERT, CREATE, etc..)
        *|-----------------------------------------------------------------
        **/

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