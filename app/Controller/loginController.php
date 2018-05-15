<?php

namespace App\Controller;

use Core\Controller;
use App\Model\Login;

class loginController extends Controller
{
    public static function actionIndex()
    {
        parent::loadView('login', 'header');
        parent::loadView('login', 'index');
        parent::loadView('login', 'footer');
    }

    public static function actionLogin($data)
    {
        $login = new Login();
        $login->login($data['desLogin'], $data['desSenha']);
    }

    public static function actionLogout()
    {
        $login = new Login();
        $login->logout();
    }
}