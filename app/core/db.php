<?php
namespace app\core;
use Exception;
use app\core\Utils;

/**
*|-----------------------------------------------------------------
*|
*|  This file contains the database class, contains all the
*|  methods needed for Xinoro to work.
*|
*|  by xoheveras
*|-----------------------------------------------------------------
**/

class DataBase
{
    public static function connect() 
    { 
        return mysqli_connect(
            $_ENV["HOST"], 
            $_ENV["USER"], 
            $_ENV["PASSWORD"], 
            $_ENV["BASENAME"], 
            $_ENV["PORT"]
        ); 
    }

    /**
    *|-----------------------------------------------------------------
    *|  @param string $query - String query containing SQL commands
    *|  @param array $arrayParams - Array params protect SQL injection
    *|
    *|  Return all line in query
    *|-----------------------------------------------------------------
    **/

    public static function Query($query, $arrayParams)
    {
        try
        {
            $mysqlconnect = DataBase::connect();
            $stmt = mysqli_prepare($mysqlconnect, $query);
            if($stmt)
            {
                if (!empty($arrayParams)) 
                {
                    $types = '';
                    $params = array();
                    foreach ($arrayParams as $param) 
                    {
                        $type = gettype($param);
                        switch ($type) 
                        {
                            case 'integer': $types .= 'i'; break;
                            case 'double': $types .= 'd'; break;
                            case 'string': $types .= 's'; break;
                            case 'boolean': $types .= 'b'; break;
                            default: $types .= 's'; $param = strval($param); break;
                        }
                        $params[] = $param;
                    }
                    mysqli_stmt_bind_param($stmt, $types, ...$params);
                }
                
                mysqli_stmt_execute($stmt);
                
                $result = mysqli_stmt_get_result($stmt);
                $rows = mysqli_fetch_all($result,MYSQLI_ASSOC);
                
                mysqli_stmt_close($stmt);
                $mysqlconnect->close();
                
                return empty($rows) ? null : $rows;
            }
            else
            {
                return null;
            }
        }
        catch(Exception $ex)
        {
            return null;
        }
    }

    /**
    *|-----------------------------------------------------------------
    *|  @param string $query - String query containing SQL commands
    *|  @param array $arrayParams - Array params protect SQL injection
    *|
    *|  executes commands(UPDATE, INSERT, CREATE, etc..)
    *|-----------------------------------------------------------------
    **/

    public static function QueryUpd($query, $arrayParams)
    {
        try
        {
            $mysqlconnect = DataBase::connect();
            $stmt = mysqli_prepare($mysqlconnect, $query);
            // Utils::stmpVarDump($result, $mysqlconnect);
            if($stmt)
            {
                // определяем типы параметров
                $types = '';
                foreach($arrayParams as $param)
                {
                    switch(gettype($param)) 
                    {
                        case 'integer': $types .= 'i'; break;
                        case 'double': $types .= 'd'; break;
                        case 'string': $types .= 's'; break;
                        case 'boolean': $types .= 'b'; break;
                        default: $types .= 's'; break;
                    }
                }
                // привязываем параметры
                if (!empty($arrayParams)) {
                    mysqli_stmt_bind_param($stmt, $types, ...$arrayParams);
                }
                
                // выполняем запрос
                $result = mysqli_stmt_execute($stmt);

                $lastID = mysqli_insert_id($mysqlconnect);
                
                $mysqlconnect->close();

                return $lastID;
            }
            else
            {
                return null;
            }
        }
        catch(Exception $ex)
        {
            Utils::debugLog("[db.php] ".$ex,"ExceptionLog");
            return null;
        }
    }

    /**
    *|-----------------------------------------------------------------
    *|  @param string $value - String
    *|
    *|  Secure sql injectin for query
    *|-----------------------------------------------------------------
    **/
    public static function injectionProtect($value)
    {
        try
        {
            $mysqlconnect = DataBase::connect();
            return mysqli_real_escape_string($mysqlconnect, $value);
        }
        catch(Exception $ex)
        {
            return null;
        }
    }

}