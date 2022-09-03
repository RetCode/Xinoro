<?php

    use app\core\Controller;
    use app\core\DataBase;

    class indexController extends Controller
    {
        function indexAction()
        {
            if(isset($_POST["answer"]))
                $this->model->createAnswer($_POST["text"], $_POST["number"], $_POST["mail"]);

            $this->view->run();
        }

        function catalogAction()
        {
            $this->view->run();
        }

        function feedbackAction()
        {

            if(isset($_POST["feedback"]))
                $this->model->feedbackCreate();

            $this->view->run();
        }

	function publicoferAction()
	{
	    $this->view->run();
	}

        function detskietovariAction()
        {
            $this->view->run();
        }

        function elictronicaAction()
        {
            $this->view->run();
        }

        function obuvyAction()
        {
            $this->view->run();
        }

        function hozoborudAction()
        {
            $this->view->run();
        }

        function odejdaAction()
        {
            $this->view->run();
        }

        function allitemsAction()
        {
            $this->view->run();
        }

        function logAction()
        {
            if(isset($_SESSION["auth"]))
                header("Location: /panel");

            if(isset($_POST["auth"]))
                $this->model->autorization();

            $this->view->run();
        }

        function regAction()
        {
            if(isset($_SESSION["auth"]))
                header("Location: /panel");

            if(isset($_POST["registration"]))
                $this->model->registration();

            $this->view->run();
        }

        function recoveryAction()
        {
            
            if(isset($_POST["recovery_start"]))
            {
                $this->model->sendMailRecovery($_POST["mail"]);
            }

            if(isset($_POST["recovery_process"]))
            {
                $this->model->recoveryProcess($_POST["newPass"],$_SESSION["recovery_maill"]);

                unset($_SESSION["recovery_key"]);
                unset($_SESSION["recovery_maill"]);
                unset($_SESSION["recovery"]);
            }

            $this->view->run();
        }
    }