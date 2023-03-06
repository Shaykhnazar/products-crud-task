<?php

namespace app\controllers;

use app\core\Controller;
use PDO;

class AccountController extends Controller
{

    /**
     * @return void
     */
    public function LoginAction(): void
    {
        $this->view->render('Login page site');
    }

    /**
     * SignIn logic here
     */
    public function signinAction()
    {
        session_start();
        if(isset($_POST['login'])) {
            $errors = [];
            if(isset($_POST['login'], $_POST['password']) && !empty($_POST['login']) && !empty($_POST['password'])) {
                $login = trim($_POST['login']);
                $password = trim($_POST['password']);

                if(filter_var($login)) {
                    $sql = "select `id`, `password` from users where login = :login ";
                    $handle = $this->model->db->query($sql, ['login' => $login]);

                    if($handle->rowCount() > 0) {
                        $getRow = $handle->fetch(PDO::FETCH_ASSOC);
//                        var_dump($getRow);
                        if(password_verify($password, $getRow['password'])) {
                            unset($getRow['password']);
//                            $_SESSION['admin'] = $getRow['id'];
                            $_SESSION = $getRow;
                            $this->view->location('/product/index');
                        }
                        else {
                            $errors[] = "Wrong Password";
                        }
                    }
                    else {
                        $errors[] = "Wrong Login or Password";
                    }

                }
                else {
                    $errors[] = "Login is not valid";
                }
            }
            else {
                $errors[] = "Login and Password are required";
            }
            // Response
            if ($errors) {
                $this->view->message(false, implode(",", $errors));
            } else {
                $this->view->message(true, 'Login successfully!');
            }
        }
    }
}