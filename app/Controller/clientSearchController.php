<?php

namespace App\Controller;

use Slim\Slim;
use Core\Controller;
use App\Model\Login;
use App\Model\Client;
use App\Model\ProdsByCommerce;
use App\Model\ClientSearch;

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

        $desFiltro = null;

        if (isset($data) && count($data) > 0) {
            foreach ($data as $key => $value) {
                if ($key < count($data) -1) {
                    $filter = explode(",", $value);
                    $desFiltro .= $filter[1] . ",";
                } else {
                    $filter = explode(",", $value);
                    $desFiltro .= $filter[1];
                }
            }
            
            $clientSearch = new ClientSearch();
            $clientSearch->setData(array(
                'idCliente' => $user['Idcliente'],
                'desFiltro' => str_replace("\"","", $desFiltro)
            ));
            $result = $clientSearch->addSearch();

            if (is_numeric($result) && $result > 0) {
                echo 'Cadastro realizado com sucesso!<br>Clique em Visualizar para ver o PDF. <a href="/client/report/' . $result . '" id="btn-viewPDF" class="btn btn-primary" target="_black" onclick="window.location.reload(true);">Visualizar <i class="fa fa-eye"></i></a>';
            } else {
                echo $result;
            }
        } else {
            echo "Nenhum dado foi recebido.";
        }
    }

    public static function actioViewHistory()
    {
        $user = self::loginVerify();
        parent::verifyClient($user);

        $result = ClientSearch::listSearch((int)$user['Idcliente']);
        
        if (is_array($result) && count($result) > 0){
            foreach($result as $key => &$value) {
                if ($value['desfiltro']) {
                    $value['desfiltro'] = count(explode(",", $value['desfiltro']));
                }
            }
        }

        $app = new Slim();
        $app->render('/template/header.php', array(
            'user' => $user,
            'page' => "Histórico de pesquisas"
        ));
        $app->render('/clientSearch/searchHistory.php', array(
            'filters' => $result
        ));
        $app->render('/template/footer.php');
    }

    public static function actionViewReport(int $id)
    {
        $user = self::loginVerify();
        parent::verifyClient($user);

        $result = ClientSearch::listSearchId($id);

        $list = [];
        $filter = explode(",", $result['desfiltro']);

        foreach($filter as $key => $value) {
            $filterResult = ProdsByCommerce::listProdutosComerciosId($value);
            $list[] = $filterResult[0];
        }
        
        foreach($list as $key => $value) {
            $idComercio[$key] = $value['idcomercio'];
        }

        array_multisort($idComercio, SORT_ASC, $list);

        $app = new Slim();
        $app->render('/clientSearch/report.php', array(
            'filters' => $list
        ));
    }

    public static function actionDelete(int $id)
    {
        $user = self::loginVerify();
        parent::verifyClient($user);

        $clientSearch = new ClientSearch();
        $clientSearch->deleteSearch($id);

        parent::notify("success", "Histórico excluído com sucesso!");

        header('location: /client/history');
        exit;
    }
}