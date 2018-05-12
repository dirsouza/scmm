<?php

namespace App\Controller;

use Core\Controller;
use App\Controller\clientController;
use App\Model\Login;
use App\Model\User;
use App\Model\Commerce;
use App\Model\Product;

class homeController extends Controller {
    public static function actionIndex() {
        login::verifyLogin();
        
        $user = new Login();
        $user->getUser((int)$_SESSION[Login::SESSION]['Idusuario']);
        $data = $user->getValues();

        if ($data['Destipo'] === '1') {
            $mainPanel = array(
                'commerces' => (is_array(Commerce::listComercios()) && count(Commerce::listComercios()) > 0) ? count(Commerce::listComercios()) : 0,
                'products' => (is_array(Product::listProdutos()) && count(Product::listProdutos()) > 0) ? count(Product::listProdutos()) : 0,
                'admins' => (is_array(User::listAdministradores()) && count(User::listAdministradores()) > 0) ? count(User::listAdministradores()) : 0,
                'clients' => (is_array(User::listClientes()) && count(User::listClientes()) > 0) ? count(User::listClientes()) : 0
            );

            $userName = User::listAdministradorId((int)$data['Idusuario']);
            $userName = explode(" ", $userName[0]['desnome']);
            $_SESSION['userName'] = $userName[0];

            parent::loadView('default', 'header', array(
                'user' => $data,
                'page' => "Painel Principal"
            ));
            parent::loadView('default', 'index', $mainPanel);
            parent::loadView('default', 'footer');
        } else {
            header("location: /client");
        }
        exit;
    }
}