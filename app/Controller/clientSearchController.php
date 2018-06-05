<?php

namespace App\Controller;

use Slim\Slim;
use Core\Controller;
use App\Model\Login;
use App\Model\Client;
use App\Model\ProdsByCommerce;

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
            'page' => "Menu de Opções"
        ));
        $app->render('/clientSearch/index.php');
        $app->render('/template/footer.php');
    }

    public static function actionViewSearch()
    {
        $user = self::loginVerify();
        parent::verifyClient($user);

        $prodsByCommerces = ProdsByCommerce::listProdutosComercios();

        $app = new Slim();
        $app->render('/template/header.php', array(
            'user' => $user,
            'page' => "Faça sua pesquisa"
        ));
        $app->render('/clientSearch/searchProducts.php', array(
            'prodsByCommerces' => $prodsByCommerces
        ));
        $app->render('/template/footer.php');
    }

    public static function actionSearch(array $data)
    {
        $user = self::loginVerify();
        parent::verifyClient($user);

        $v = null;

        if (isset($data) && count($data) > 0) {
            foreach ($data as $key => $value) {
                if ($key < count($data) -1) {
                    $a = explode(",", $value);
                    $v .= $a[1] . ", ";
                } else {
                    $a = explode(",", $value);
                    $v .= $a[1];
                }
            }
            
            echo $v;
            //var_dump(explode(",", $data['rowData'][0]));
        } else {
            echo "POST não recebido.";
        }
    }
}