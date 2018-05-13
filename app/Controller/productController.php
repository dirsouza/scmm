<?php

namespace App\Controller;

use Core\Controller;
use App\Model\Login;
use App\Model\Product;

class productController extends Controller
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

        $products = Product::listProdutos();

        parent::loadView('default', 'header', array(
            'user' => $user,
            'page' => "Lista de Produtos"
        ));
        parent::loadView('product', 'index', $products);
        parent::loadView('default', 'footer');
    }

    public static function actionViewCreate()
    {
        $user = self::loginVerify();

        if (isset($_SESSION['restoreData'])) {
            $data = array(
                'desNome' => $_SESSION['restoreData']['desNome'],
                'desMarca' => $_SESSION['restoreData']['desMarca'],
                'desDescricao' => $_SESSION['restoreData']['desDescricao']
            );
            unset($_SESSION['restoreData']);
        } else {
            $data = null;
        }

        parent::loadView('default', 'header', array(
            'user' => $user,
            'page' => "Novo Produto"
        ));
        parent::loadView('product', 'create', $data);
        parent::loadView('default', 'footer');
    }

    public static function actionCreate($data)
    {
        $user = self::loginVerify();

        $product = new Product();
        $product->setData($data);
        $product->addProduto();

        header("location: /admin/product");
        exit;
    }

    public static function actionViewUpdate($id)
    {
        $user = self::loginVerify();

        $product = Product::listProdutoId((int)$id);

        parent::loadView('default', 'header', array(
            'user' => $user,
            'page' => "Editar Produto"
        ));
        parent::loadView('product', 'update', $product[0]);
        parent::loadView('default', 'footer');
    }

    public static function actionUpdate($id, $data)
    {
        $user = self::loginVerify();

        $product = new Product();
        $product->setData($data);
        $product->updateProduto((int)$id);

        header("location: /admin/product");
        exit;
    }

    public static function actionDelete($id)
    {
        $user = self::loginVerify();

        $product = new Product();
        $product->deleteProduto((int)$id);

        header("location: /admin/product");
        exit;
    }

    public static function actionViewReport()
    {
        $user = self::loginVerify();

        $products = Product::listProdutos();

        parent::loadView("product", "report", $products);
    }
}