<?php


    use app\core\DataBase;
    use app\core\Model;

    // ini_set('display_errors','Off');
    // ini_set('error_reporting', E_ALL );

    session_start();

    require_once 'app/core/db.php';
    require_once 'vendor/phpmailer/PHPMailerAutoload.php';

    class indexModel extends Model
    {

        function feedbackCreate()
        {
            $mail = $_POST["mail"];
            $comment = $_POST["comment"];
            $date = date("Y-m-d H:i:s");

            DataBase::QueryUpd("INSERT INTO `feedback`(`id`, `email`, `rate`, `comment`, `date`, `state`) 
            VALUES (null,'$mail',5,'$comment','$date',0)");
            header("Location: /feedback");
        }

        function recoveryProcess($newPass,$mail)
        {
            $pass = md5($newPass);
            DataBase::QueryUpd("UPDATE `users` SET `password` = '$pass' WHERE email = '$mail'");
            header("Location: /log");
        }
        
        function MailSender($subject,$mail_user,$html)
        {
            // Отправка письма
            $mail = new PHPMailer;
            $mail->CharSet = 'utf-8';

            $mail->isSMTP();
            $mail->Host = 'smtp.mail.ru';  																							// Specify main and backup SMTP servers
            $mail->SMTPAuth = true;
            $mail->Username = 'polandshopes@mail.ru';
            $mail->Password = 'cbAZFNxU5TRrSguB5mik';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Отправка
            $mail->setFrom('polandshopes@mail.ru'); // от кого будет уходить письмо?
            $mail->addAddress($mail_user);
            $mail->Subject = $subject;

            // Подключение html
            $mail->isHTML(true);
            $mail->Body = $html;
            $mail->AltBody = '';

            if(!$mail->send())
                echo 'Error';
        }

        function sendMailRecovery($mail)
        {
            $_SESSION["recovery"] = true;
            $_SESSION["recovery_key"] = $this->gen_hash(80);
            $_SESSION["recovery_maill"] = $mail;

            $html = '<!DOCTYPE html>
            <html lang="ru" style="
            background-color: #212427;
            color: white;
           width:600px;
           margin: 0px auto;">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="vendor/Bootstrap5/css/bootstrap.min.css">
            </head>
            <body style="
                background-color: #212427;
                color: white;
               width:600px;
               margin: 0px auto;">
               <div style="width:100%; height:40vh;  background-color: #212427;
               color: white;">
                <div class="menu-block d-flex" style="display:flex;    background-color: #272A2E;
                height: 60px;
                color: #CDCECE;">
                    <img width="45px" height="45px" class="mt-2 ms-4" style="margin-left: 5%;
                    margin-top: 0.5%;" src="https://polandshop.store/public/img/logo.png">
                    <p style="    margin-top: 2%;
                    color: WHITE !important;
                    font-size: 20px;    font-family: "Montserrat";
                    font-style: normal;
                    font-weight: 600;
                    font-size: 20px;
                    line-height: 15px; class="m-text-t mt-4 ms-2"><a target="_blank" style="color:white" href="https://polandshop.store"> Poland Shop</a></p>
                </div>
                    <div class="container-md ms-4 me-4">
                        <p align="center" class="g-text pt-4 mb-0" style="   ;
                font-style: normal;
                font-weight: 600;
                font-size: 21px;
                line-height: 30px;
                margin-top: 5%;
                color: #CDCECE;">Восстановление аккаунта</p>
                        <p align="center" class="l-text mb-2 mb-4 pb-2" style=" 
                font-style: normal;
                font-weight: 600;
                font-size: 12px;
                line-height: 15px;
                /* identical to box height */
            
                margin-bottom: 2%;
                margin: 0 auto;
                display: block;
                color: #A3A1A1;">Если вы не делали это, прогинорируйте сообщение</p> 
                        
                            <a href="https://polandshop.store/recovery?hesh='.$_SESSION["recovery_key"].'"><input class="of-button mb-5 mb-lg-0" style=" margin-top:5%;   width: 400px;
                height: 40px;
                background: #FD992B;
                box-shadow: 0px 4px 17px #FD992B;
                border-radius: 10px;
                border: none;
                color: white;
                transition: all 0.1s;     margin: 0 auto;
                display: block;
                margin-top: 2%;" name="createOrder" type="submit" value="Восстановить"></a>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </body>
            <style>
            </html>';


            $this->MailSender("Poland Shop - Восстановление пароля",$mail,$html);

            header("Location:/recovery");
        }

        function gen_hash($length = 6)
        {				
            $chars = 'qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP'; 
            $size = strlen($chars) - 1; 
            $password = ''; 
            while($length--) {
                $password .= $chars[random_int(0, $size)]; 
            }
            return $password;
        }

        function createAnswer($text, $number, $mail)
        {
            $date = date("Y-m-d H:i:s");
            DataBase::QueryUpd("INSERT INTO `answers` (`id`, `number`, `email`, `date`, `text`) 
            VALUES (NULL, '$number', '$mail', '$date', '$text');");
            header("Location: /");
        }

        function registration()
        {
            $email = $_POST["mail"];
            if(DataBase::Query("SELECT * FROM users WHERE email = '$email'") != null)
            {
                $_SESSION["wrong"] = true;
                $_SESSION["wrong-text"] = "Данная почта уже зарегестрирована";
                header("Location: /reg");
            }
            else
            {

                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $code = "";

                while(True)
                {
                    $code = substr(str_shuffle($permitted_chars), 0, 13);

                    if(DataBase::Query("SELECT * FROM users WHERE refcode = '$code'") == null)
                        break;
                }

                # Данные рефералов 4 Lvl
                $rf1 = 0;	
                $rf2 = 0;
                $rf3 = 0;
                $rf4 = 0;

                if(!empty($_POST["refcode"]))
                {
                    $refCodeUser = $_POST["refcode"];
                    $referal = DataBase::Query("SELECT * FROM users WHERE refcode = '$refCodeUser'"); 
                    $rf1 = $referal["id"];

                    if($referal["rf1"] != 0)
                    $rf2 = $referal["rf1"];
                    if($referal["rf2"] != 0)
                    $rf3 = $referal["rf2"];
                    if($referal["rf3"] != 0)
                    $rf4 = $referal["rf3"];
		    
                }

                $surname = $_POST["surname"];
                $name = $_POST["name"];
                $dubsurname = $_POST["dubsurname"];
                $phone = $_POST["phone"];
                $password = md5($_POST["password"]);
                $home_adress = $_POST["home_adress"];
    
                DataBase::QueryUpd("INSERT INTO `users`(`id`, `surname`, `name`, `dubsurname`, `phone`, `email`, `password`, `home_adress`, `money`, `refcode`, `deposite`, `alevel`, `rf1`, `rf2`, `rf3`, `rf4`) 
                VALUES (null,'$surname','$name','$dubsurname','$phone','$email','$password','$home_adress',0,'$code',0,0,$rf1,$rf2,$rf3,$rf4)");

                unset($_SESSION["wrong"]);
                unset($_SESSION["wrong-text"]);

                $html = '<!DOCTYPE html>
                <html lang="ru" style="
                background-color: #212427;
                color: white;
               width:600px;
               margin: 0px auto;">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="stylesheet" href="vendor/Bootstrap5/css/bootstrap.min.css">
                </head>
                <body style="
                    background-color: #212427;
                    color: white;
                   width:600px;
                   margin: 0px auto;">
                   <div style="width:100%; height:40vh;  background-color: #212427;
                   color: white;">
                    <div class="menu-block d-flex" style="display:flex;    background-color: #272A2E;
                    height: 60px;
                    color: #CDCECE;">
                        <img width="45px" height="45px" class="mt-2 ms-4" style="margin-left: 5%;
                        margin-top: 0.5%;" src="https://polandshop.store/public/img/logo.png">
                        <p style="    margin-top: 2%;
                        color: WHITE !important;
                        font-size: 20px;    font-family: "Montserrat";
                        font-style: normal;
                        font-weight: 600;
                        font-size: 20px;
                        line-height: 15px; class="m-text-t mt-4 ms-2"><a target="_blank" style="color:white" href="https://polandshop.store"> Poland Shop</a></p>
                    </div>
                        <div class="container-md ms-4 me-4">
                            <p align="center" class="g-text pt-4 mb-0" style="   ;
                    font-style: normal;
                    font-weight: 600;
                    font-size: 21px;
                    line-height: 30px;
                    margin-top: 5%;
                    color: #CDCECE;">Вы успешно зарегестрировались</p>
                            <p align="center" class="l-text mb-2 mb-4 pb-2" style=" 
                    font-style: normal;
                    font-weight: 600;
                    font-size: 12px;
                    line-height: 15px;
                    /* identical to box height */
                
                    margin-bottom: 2%;
                    margin: 0 auto;
                    display: block;
                    color: #A3A1A1;">Оформление заказа стало проще</p> 
                            
                                <input id="fOrder" name="finalOrder" type="text" hidden>
                                <a href="https://polandshop.store/create"><input class="of-button mb-5 mb-lg-0" style=" margin-top:5%;   width: 400px;
                    height: 40px;
                    background: #FD992B;
                    box-shadow: 0px 4px 17px #FD992B;
                    border-radius: 10px;
                    border: none;
                    color: white;
                    transition: all 0.1s;     margin: 0 auto;
                    display: block;
                    margin-top: 2%;" name="createOrder" type="submit" value="Оформить заказ"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </body>
                <style>
                </html>';

                $this->MailSender("Poland Shop - Регистрация аккаунта",$email,$html);

                header("Location: /log");
            }   
        }

        function autorization()
        {
            $email = $_POST["mail"];
            $password = md5($_POST["password"]);
            $query = DataBase::Query("SELECT * FROM users WHERE email = '$email' and password = '$password'");
            if($query != null)
            {
                $_SESSION["auth"] = true;
                $_SESSION["id"] = $query["id"];
                $_SESSION["name"] = $query["name"];
                $_SESSION["surname"] = $query["surname"];
                $_SESSION["dubsurname"] = $query["dubsurname"];
                $_SESSION["phone"] = $query["phone"];
                $_SESSION["email"] = $query["email"];
                $_SESSION["home_adress"] = $query["home_adress"];
                $_SESSION["alevel"] = $query["alevel"];
    
                unset($_SESSION["wrong"]);
                unset($_SESSION["wrong-text"]);
    
                header("Location: /panel");
            }
            else
            {
                $_SESSION["wrong"] = true;
                $_SESSION["wrong-text"] = "Неверная почта или пароль";
                header("Location: /log");
            }
        }
    }