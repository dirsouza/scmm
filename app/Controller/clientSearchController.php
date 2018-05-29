<?php

namespace App\Controller;

use Slim\Slim;
use Core\Controller;
use App\Model\Login;
use App\Model\Client;

class clientSearchController extends Controller
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

        $userName = Client::listClienteId((int)$user['Idusuario']);
        $userName = explode(" ", $userName[0]['desnome']);
        $_SESSION['userName'] = $userName[0];

        $app = new Slim();
        $app->render('/template/header.php', array(
            'user' => $user,
            'page' => "Faça sua pesquisa"
        ));
        $app->render('/clientSearch/index.php');
        $app->render('/template/footer.php');
    }
}