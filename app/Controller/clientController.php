<?php

namespace App\Controller;

use Slim\Slim;
use Core\Controller;
use App\Model\Login;
use App\Model\Client;

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
        parent::verifyAdmin($user);

        $clients = Client::listClientes();

        $app = new Slim();
        $app->render('/template/header.php', array(
            'user' => $user,
            'page' => "Faça sua pesquisa"
        ));
        $app->render('/client/index.php', array(
            'clients' => $clients
        ));
        $app->render('/template/footer.php');
    }

    public static function actionViewReport()
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $clients = Client::listClientes();

        $app = new Slim();
        $app->render('/client/report.php', array(
            'clients' => $clients
        ));
    }
}