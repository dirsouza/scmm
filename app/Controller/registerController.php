<?php

namespace App\Controller;

use Slim\Slim;
use App\Model\User;

class registerController
{
    public static function actionIndex()
    {
        $app = new Slim();
        $app->render('/login/header.php');
        $app->render('/login/register.php');
        $app->render('/login/footer.php');
    }

    public static function actionRegister($data)
    {
        if ($data['desSenha'] === $data['desReSenha']) {
            $user = new User();
            $user->setData($data);
            $user->addUsuario();

            $_SESSION['register'] = array(
                'msg' => "Usuário Cadastrado com Sucesso!"
            );

            header('location: /login');
            exit;
        } else {
            $_SESSION['register'] = array(
                'desLogin' => $data['desLogin'],
                'desNome' => $data['desNome'],
                'desEmail' => $data['desEmail'],
                'msg' => "As senhas não são identicas."
            );
            
            header('location: /register');
            exit;
        }
    }
}