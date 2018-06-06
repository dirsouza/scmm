<?php

namespace App\Controller;

use Slim\Slim;
use Core\Controller;
use App\Model\Home;
use App\Controller\clientController;
use App\Model\Administrator;
use App\Model\Login;

class homeController extends Controller
{
    private function loginVerify()
    {
        Login::verifyLogin();

        $user = new Login();
        $user->getUser((int)$_SESSION[Login::SESSION]['Idusuario']);

        return $user->getValues();
    }

    public static function actionIndex()
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $mainPanel = array(
            'commerces' => Home::getCommerces(),
            'products' => Home::getProducts(),
            'admins' => Home::getAdministrators(),
            'clients' => Home::getClients()
        );

        $userName = Administrator::listAdministradorId((int)$user['Idusuario']);
        $userName = explode(" ", $userName[0]['desnome']);
        $_SESSION['userName'] = $userName[0];
        
        $app = new Slim();
        $app->render('/template/header.php', array(
            'user' => $user,
            'page' => "Painel Principal"
        ));
        $app->render('/template/index.php', array(
            'mainPanel' => $mainPanel
        ));
        $app->render('/template/footer.php');
    }

    public static function actionGetCount()
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        print_r($result = Home::getCountFilters());
    }
}