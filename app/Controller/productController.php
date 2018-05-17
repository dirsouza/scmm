<?php

namespace App\Controller;

use Slim\Slim;
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

        $app = new Slim();
        $app->render('/template/header.php', array(
            'user' => $user,
            'page' => "Lista de Produtos"
        ));
        $app->render('/product/index.php', array(
            'products' => $products
        ));
        $app->render('/template/footer.php');
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

        $app = new Slim();
        $app->render('/template/header.php', array(
            'user' => $user,
            'page' => "Novo Produto"
        ));
        $app->render('/product/create.php', array(
            'data' => $data
        ));
        $app->render('/template/footer.php');
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

        $app = new Slim();
        $app->render('/template/header.php', array(
            'user' => $user,
            'page' => "Editar Produto"
        ));
        $app->render('/product/update.php', array(
            'product' => $product[0]
        ));
        $app->render('/template/footer.php');
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

        $app = new Slim();
        $app->render('/product/report.php', array(
            'products' => $products
        ));
    }

    public static function getProduct($id)
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $setProduct = Product::listProdutoId((int)$id);

        echo json_encode($setProduct);
    }
}