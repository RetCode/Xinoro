<?php

    namespace application;

    // Дебаг
    // ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    
    // Подгрузка всех namespace
    require_once "vendor/autoload.php";

    // Подгрузка классов
    use app\interfaces\SessionUI;
    use app\core\Router;
    use Dotenv\Dotenv;

    // Подгрузка envairoment переменных
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // Старт роутера
    SessionUI::start();
    Router::start();