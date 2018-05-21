<?php

namespace App\Controller;

use Slim\Slim;
use Core\Controller;
use App\Model\Forgot;
use App\Model\Login;

class forgotController extends Controller
{
    public static function actionIndex()
    {
        $app = new Slim();
        $app->render('/forgot/header.php');
        $app->render('/forgot/index.php');
        $app->render('/forgot/footer.php');
    }

    public static function actionForgot($data)
    {
        Forgot::getForgot($data['desEmail']);

        $_SESSION['register'] = array(
            'msg' => "<b>E-mail enviado com Sucesso!</b><br>Verifique as instruções no seu e-mail."
        );

        header('location: /login');
        exit;
    }

    public static function actionViewReset($data)
    {
        $user = Forgot::validForgotDecrypt($data['code']);

        $app = new Slim();
        $app->render('/forgot/header.php');
        $app->render('/forgot/reset.php', array(
            'name' => $user['desnome'],
            'code' => $data['code']
        ));
        $app->render('/forgot/footer.php');
    }

    public static function actionReset($data)
    {
        $user = Forgot::validForgotDecrypt($data['code']);

        $login = new Login();
        $login->getUser($user['idusuario']);

        $newPassword = password_hash($data['dessenha'], PASSWORD_DEFAULT);

        $forgot = new Forgot();
        $forgot->setPassword($newPassword);

        $_SESSION['register'] = array(
            'msg' => "Senha redefinida com sucesso!"
        );

        header('location: /login');
        exit;
    }
}