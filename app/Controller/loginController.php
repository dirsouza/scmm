<?php

namespace App\Controller;

use Slim\Slim;
use Core\Controller;
use App\Model\Login;

class loginController extends Controller
{
    public static function actionIndex()
    {
        $app = new Slim();
        $app->render('/login/header.php');
        $app->render('/login/index.php');
        $app->render('/login/footer.php');
    }

    public static function actionLogin($data)
    {
        $login = new Login();
        $login->login($data['desLogin'], $data['desSenha']);

        parent::verifyLogin();
    }

    public static function actionLogout()
    {
        $login = new Login();
        $login->logout();

        parent::verifyLogin();
    }
}