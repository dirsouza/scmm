<?php

namespace App\Controller;

use Slim\Slim;
use Core\Controller;
use App\Model\Login;
use App\Model\Commerce;

class commerceController extends Controller
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

        $commerces = Commerce::listComercios();

        $app = new Slim();
        $app->render('/template/header.php', array(
            'user' => $user,
            'page' => "Lista de Comércios"
        ));
        $app->render('/commerce/index.php', array(
            'commerces' => $commerces
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
                'desCEP' => $_SESSION['restoreData']['desCEP'],
                'desRua' => $_SESSION['restoreData']['desRua'],
                'desBairro' => $_SESSION['restoreData']['desBairro']
            );
            unset($_SESSION['restoreData']);
        } else {
            $data = null;
        }

        $app = new Slim();
        $app->render('/template/header.php', array(
            'user' => $user,
            'page' => "Novo Comércio"
        ));
        $app->render('/commerce/create.php', array(
            'data' => $data
        ));
        $app->render('/template/footer.php');
    }

    public static function actionCreate($data)
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $commerce = new Commerce();
        $commerce->setData($data);
        $commerce->addComercio();

        parent::notify("success", "Comércio cadastrado com sucesso!");

        header("location: /admin/commerce");
        exit;
    }

    public static function actionViewUpdate($id)
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $commerce = Commerce::listComercioId((int)$id);

        $app = new Slim();
        $app->render('/template/header.php', array(
            'user' => $user,
            'page' => "Editar Comércio"
        ));
        $app->render('/commerce/update.php', array(
            'commerce' => $commerce[0]
        ));
        $app->render('/template/footer.php');
    }

    public static function actionUpdate($id, $data)
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $commerce = new Commerce();
        $commerce->setData($data);
        $commerce->updateComercio((int)$id);

        parent::notify("success", "Comércio atualizado com sucesso!");

        header("location: /admin/commerce");
        exit;
    }

    public static function actionDelete($id)
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $commerce = new Commerce();
        $commerce->deleteComercio((int)$id);

        parent::notify("success", "Comércio excluído com sucesso!");

        header("location: /admin/commerce");
        exit;
    }

    public static function actionViewReport()
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $commerces = Commerce::listComercios();

        $app = new Slim();
        $app->render('/commerce/report.php', array(
            'commerces' => $commerces
        ));
    }

    public static function actionGetCep($cep)
    {
        $user = self::loginVerify();
        parent::verifyAdmin($user);

        $setCep = Commerce::getCep($cep);
        echo json_encode($setCep);
    }
}