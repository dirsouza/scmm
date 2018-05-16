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
        parent::verifyAdmin($user);

        $products = Product::listProdutos();

        parent::loadView('template/header', array(
            'user' => $user,
            'page' => "Lista de Produtos"
        ));
        parent::loadView('product/index', $products);
        parent::loadView('template/footer');
    }

    public static function actionViewCreate()
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

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

        parent::loadView('template/header', array(
            'user' => $user,
            'page' => "Novo Produto"
        ));
        parent::loadView('product/create', $data);
        parent::loadView('template/footer');
    }

    public static function actionCreate($data)
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $product = new Product();
        $product->setData($data);
        $product->addProduto();

        parent::notify("success", "Produto cadastrado com sucesso!");

        header("location: /admin/product");
        exit;
    }

    public static function actionViewUpdate($id)
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $product = Product::listProdutoId((int)$id);

        parent::loadView('template/header', array(
            'user' => $user,
            'page' => "Editar Produto"
        ));
        parent::loadView('product/update', $product[0]);
        parent::loadView('template/footer');
    }

    public static function actionUpdate($id, $data)
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $product = new Product();
        $product->setData($data);
        $product->updateProduto((int)$id);

        parent::notify("success", "Produto atualizado com sucesso!");

        header("location: /admin/product");
        exit;
    }

    public static function actionDelete($id)
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $product = new Product();
        $product->deleteProduto((int)$id);

        parent::notify("success", "Produto excluído com sucesso!");

        header("location: /admin/product");
        exit;
    }

    public static function actionViewReport()
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $products = Product::listProdutos();

        parent::loadView('product/report', $products);
    }
}