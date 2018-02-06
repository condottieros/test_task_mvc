<?php
namespace app\controllers;
use app\src\User;
use app\src\Controller;
class AuthController extends Controller
{
    public function actionLogin(){
        $user  = new User();
        if(isset($_POST['login']) && isset($_POST['pass'])){
            $login = $_POST['login'];
            $pass = $_POST['pass'];
            $user->auth($login,$pass);
            if ($user->checkAuth()) {header('Location: /admin');}
            else {$message = "Неверный логин или пароль";}
        }

        return $this->view('admin/login',['message'=>$message]);
    }
    public function actionLogout(){
        $user = new User();
        if($user->checkAuth())  $user->quit();
        header("Location:http://".ROOT);
    }
}