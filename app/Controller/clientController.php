<?php

namespace App\Controller;

use Core\Controller;
use App\Model\Login;
use App\Model\User;

class clientController extends Controller {
    public static function actionIndex() {
        login::verifyLogin();
        
        $user = new Login();
        $user->getUser((int)$_SESSION[Login::SESSION]['Idusuario']);
        $data = $user->getValues();

        $userName = User::listClienteId((int)$data['Idusuario']);
        $userName = explode(" ", $userName[0]['desnome']);
        $_SESSION['userName'] = $userName[0];

        parent::loadView('default', 'header', array(
            'user' => $data,
            'page' => "Faça sua pesquisa"
        ));
        parent::loadView('clientSearch', 'index');
        parent::loadView('default', 'footer');
    }
}