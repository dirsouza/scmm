<?php

namespace App\Controller;

use Slim\Slim;
use Core\Controller;
use App\Model\Forgot;
use App\Model\Login;

class forgotController extends Controller
{
    public static function actionViewIndex()
    {
        $app = new Slim();
        $app->render('/forgot/header.php');
        $app->render('/forgot/index.php');
        $app->render('/forgot/footer.php');
    }

    public static function actionForgot($data)
    {
        $result = Forgot::getForgot($data['desEmail']);

        if ($result) {
            $_SESSION['register'] = array(
                'msg' => "<b>E-mail enviado com Sucesso!</b><br>Verifique as instruções no seu e-mail."
            );
        } else {
            $_SESSION['error'] = array(
                'msg' => "<b>O e-mail não pode ser enviado.</b><br>$result"
            );
        }

        header('location: /login');
        exit;
    }

    public static function actionViewReset($data)
    {
        $codeDecrypted = Forgot::forgotCodeDecrypt($data['code']);
        $user = Forgot::validForgotDecrypt($codeDecrypted);

        $app = new Slim();
        $app->render('/forgot/header.php');
        $app->render('/forgot/reset.php', array(
            'name' => $user['desnome'],
            'idusuario' => $user['idusuario']
        ));
        $app->render('/forgot/footer.php');
    }

    public static function actionReset($data)
    {
        Forgot::setPassword($data['desIdUsuario'], $data['desSenha']);

        $_SESSION['register'] = array(
            'msg' => "Senha redefinida com sucesso!"
        );

        header('location: /login');
        exit;
    }
}