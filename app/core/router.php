<?php

    namespace app\core;

    class Router
    {
        public static function start()
        {
            $route = trim($_REQUEST['route']??'index');

            switch($route)
            {
                case "index": Router::done("index","index"); break;
                case "panel": Router::done("profile","panel"); break;
                case "order": Router::done("profile","order"); break;
                case "info": Router::done("profile","info"); break;
                case "create": Router::done("profile","create"); break;
                case "invest": Router::done("profile","invest"); break;
                case "referals": Router::done("profile","referals"); break;
                case "moneyback": Router::done("profile","moneyback"); break;
                case "packet": Router::done("profile","packet"); break;
                case "packets": Router::done("profile","packets"); break;
                case "reg": Router::done("index","reg"); break;
                case "log": Router::done("index","log"); break;
		        case "logout": Router::done("profile","logout"); break;
                case "feedback": Router::done("index","feedback"); break;
                case "feedbackAppruve": Router::done("profile","feedbackAppruve"); break;
		
                // Платежка AdvCash
                case "success_adv": Router::done("profile","success_adv"); break;
                case "fail_adv": Router::done("profile","fail_adv"); break;
                case "status_adv": Router::done("profile","status_adv"); break;

                case "catalog": Router::done("index","catalog"); break;
                case "detskie-tovari": Router::done("index","detskietovari"); break;
                case "elictronica": Router::done("index","elictronica"); break;
                case "obuvy": Router::done("index","obuvy"); break;
                case "hoz-oborud": Router::done("index","hozoborud"); break;
                case "odejda": Router::done("index","odejda"); break;
                case "all-items": Router::done("index","allitems"); break;
		        case "public-ofer": Router::done("index","publicofer"); break;
		        case "pay" : Router::done("profile","pay"); break;
                case "recovery" : Router::done("index","recovery"); break;

                // Админка
                case "apanel": Router::done("profile","apanel"); break;
                case "aorder": Router::done("profile","aorder"); break;
                case "answers": Router::done("profile","answers"); break;
                case "support": Router::done("profile","support"); break;
                case "users": Router::done("profile","users"); break;
                case "useredit": Router::done("profile","useredit"); break;
                case "news": Router::done("profile","news"); break;
                case "settings": Router::done("profile","settings"); break;

//case "app/views/profile/ajax.php": require_once("polandsh.vh111.hosterby.com/app/views/profile/ajax.php"); break;
                

                default: Router::error(404);
            }
        }

        /** @param string $controller - Скрипт контролирующий страницу
        **  @param string $action - Метод в контроллере который отвечает за запуск страницы */
        public static function done($controller,$action)
        {
            $newAction = $action."Action";
            $newController = $controller."Controller";
            require_once("app/controllers/".$newController.".php");
            $pageController = new $newController($controller, $action);
            $pageController->$newAction();
        }

        /** @param string $code - Принимает код ошибки, после вывидет её на экран  */
        public static function error($code)
        {
            require_once("app/views/error/error.html");
            exit;
        }
    }