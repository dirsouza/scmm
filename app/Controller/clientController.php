<?php

namespace App\Controller;

use Core\Controller;
use App\Model\Login;
use App\Model\User;

class clientController extends Controller
{
    private function loginVerify()
    {
        Login::verifyLogin();

        $user = new Login();
        $user->getUser((int)$_SESSION[Login::SESSION]['Idusuario']);

        return $user->getValues();
    }

    public static function actionViewIndex()
    {
        $user = self::loginVerify();
        parent::verifyClient($user);

        $userName = User::listClienteId((int)$user['Idusuario']);
        $userName = explode(" ", $userName[0]['desnome']);
        $_SESSION['userName'] = $userName[0];

        parent::loadView('template/header', array(
            'user' => $user,
            'page' => "Faça sua pesquisa"
        ));
        parent::loadView('clientSearch/index');
        parent::loadView('template/footer');
    }
    
    /*private function verifyClient($user)
    {
        if ($user['Destipo'] == 1) {
            header("location: /admin");
            exit;
        }
    }*/
}