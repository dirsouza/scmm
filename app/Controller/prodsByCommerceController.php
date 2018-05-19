<?php

namespace App\Controller;

use Slim\Slim;
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
        parent::verifyAdmin($user);

        $prodsByCommerces = ProdsByCommerce::listProdutosComercios();

        $app = new Slim();
        $app->render('/template/header.php', array(
            'user' => $user,
            'page' => "Lista de Produtos por Comércio"
        ));
        $app->render('/prodsByCommerce/index.php', array(
            'prodsByCommerces' => $prodsByCommerces
        ));
        $app->render('/template/footer.php');
    }

    public static function actionViewCreate()
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $commerces = Commerce::listComercios();

        $app = new Slim();
        $app->render('/template/header.php', array(
            'user' => $user,
            'page' => "Nova Associação de Produtos por Comércio"
        ));
        $app->render('/prodsByCommerce/create.php', array(
            'commerces' => $commerces
        ));
        $app->render('/template/footer.php');
    }

    public static function actionCreate($data)
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $idComercio = $data['idComercio'];
        array_shift($data);
        $data = array_combine($data['idProduto'], $data['desPreco']);

        $prodsByCommerces = new ProdsByCommerce();
        $prodsByCommerces->setData(['idComercio' => $idComercio]);
        foreach ($data as $key => $value) {
            $prodsByCommerces->setData(['idProduto' => (int)$key]);
            $prodsByCommerces->setData(['desPreco' => str_replace(",", ".", str_replace(".", "", $value))]);
            $prodsByCommerces->addProdutoComercio();
        }
        
        parent::notify("success", "Associação de Produtos por Comércio cadastrada com sucesso!");

        header("location: /admin/prodsByCommerce");
        exit;
    }

    public static function actionUpdate($id, $data)
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $prodsByCommerce = new ProdsByCommerce();
        $prodsByCommerce->setData($data);
        $prodsByCommerce->updateProdutoComercio((int)$id);

        parent::notify("success", "Associação de Produtos por Comércio atualizado com sucesso!");

        header("location: /admin/prodsByCommerce");
        exit;
    }

    public static function actionDelete($id)
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $prodsByCommerce = new ProdsByCommerce();
        $prodsByCommerce->deleteProdutoComercio((int)$id);

        parent::notify("success", "Produto Associado ao Comércio excluído com sucesso!");

        header("location: /admin/prodsByCommerce");
        exit;
    }

    public static function actionDeleteAll($id)
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $prodsByCommerce = new ProdsByCommerce();
        $prodsByCommerce->deleteProdutoComercioAll((int)$id);

        parent::notify("success", "Produtos Associados ao Comércio excluído com sucesso!");

        header("location: /admin/prodsByCommerce");
        exit;
    }

    public static function actionViewReport(int $id = null, $method = "all")
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $app = new Slim();

        switch ($method) {
            case 'commerce':
                $getCommerce = ProdsByCommerce::listProdComeIdComercio($id);
                $getDataCommerce = Commerce::listComercioId($getCommerce[0]['idcomercio']);
                
                if (is_array($getCommerce) && count($getCommerce) > 0) {
                    $app->render('/prodsByCommerce/reportCommerce.php', array(
                        'commerce' => $getDataCommerce[0],
                        'products' => $getCommerce
                    ));
                } else {
                    echo '<script>window.close()</script>';
                    parent::notify("warning", "Nenhum registro foi encontrado para essa consulta.");
                    exit;
                }
                break;
            case 'product':
                $getProduct = ProdsByCommerce::listProdComeIdProduto($id);
                $getDataProduct = Product::listProdutoId($getProduct[0]['idproduto']);

                if (is_array($getProduct) && count($getProduct) > 0) {
                    $app->render('/prodsByCommerce/reportProduct.php', array(
                        'products' => $getDataProduct[0],
                        'commerces' => $getProduct
                    ));
                } else {
                    echo '<script>window.close()</script>';
                    parent::notify("warning", "Nenhum registro foi encontrado para essa consulta.");
                    exit;
                }
                break;
            default:
                $getProdsByCommerce = ProdsByCommerce::listProdutosComercios();

                if (is_array($getProdsByCommerce) && count($getProdsByCommerce) > 0) {
                    $app->render('/prodsByCommerce/reportAll.php', array(
                        'prodsByCommerce' => $getProdsByCommerce,
                        'idCommerce' => 0
                    ));
                } else {
                    echo '<script>window.close()</script>';
                    parent::notify("warning", "Nenhum registro foi encontrado para essa consulta.");
                    exit;
                }
                break;
        }
    }

    public static function getProdsByCommerce($id)
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $getProdsByCommerce = ProdsByCommerce::listProdutosComerciosId((int)$id);

        echo json_encode($getProdsByCommerce);
    }

    public static function getProductDiff($id)
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $products = Product::listProdutos();
        $prodsByCommerces = ProdsByCommerce::listProdComeIdComercio($id);
        
        if (is_array($prodsByCommerces) && count($prodsByCommerces) > 0) {
            for($i = 0; $i < count($products); $i++){
                if (array_key_exists($i, $prodsByCommerces)) {
                    if ($products[$i]['idproduto'] === $prodsByCommerces[$i]['idproduto']) {
                        $diff[] = $products[$i];
                    }
                }
            }

            for($i = 0; $i < count($diff); $i++) {
                if ($diff[$i]['idproduto'] === $products[$i]['idproduto']) {
                    unset($products[$i]);
                }
            }
        }

        echo json_encode($products);
    }
}