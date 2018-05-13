<?php

namespace App\Controller;

use Core\Controller;
use App\Model\Login;
use App\Model\Commerce;
use App\Model\Product;
use App\Model\ProdsByCommerce;

class prodsByCommerceController extends Controller
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

        $prodsByCommerces = ProdsByCommerce::listProdutosComercios();

        parent::loadView('default', 'header', array(
            'user' => $user,
            'page' => "Lista de Produtos por Comércio"
        ));
        parent::loadView('prodsByCommerce', 'index', $prodsByCommerces);
        parent::loadView('default', 'footer');
    }

    public static function actionViewCreate()
    {
        $user = self::loginVerify();

        $commerces = Commerce::listComercios();
        $products = Product::listProdutos();

        parent::loadView('default', 'header', array(
            'user' => $user,
            'page' => "Novo Produto"
        ));
        parent::loadView('prodsByCommerce', 'create', array(
            'commerces' => $commerces,
            'products' => $products
        ));
        parent::loadView('default', 'footer');
    }

    public static function actionCreate($data)
    {
        $user = self::loginVerify();

        
    }

    public static function actionViewUpdate($id)
    {
        $user = self::loginVerify();

        
    }

    public static function actionUpdate($id, $data)
    {
        $user = self::loginVerify();

        
    }

    public static function actionDelete($id)
    {
        $user = self::loginVerify();

        
    }

    public static function actionViewReport()
    {
        $user = self::loginVerify();

        
    }

    public static function getProduct($id)
    {
        $user = self::loginVerify();

        $setProduct = Product::listProdutoId($id);

        echo json_encode($setProduct[0]);
    }
}