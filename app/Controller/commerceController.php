<?php

namespace App\Controller;

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

        $commerces = Commerce::listComercios();

        parent::loadView('default', 'header', array(
            'user' => $user,
            'page' => "Lista de Comércios"
        ));
        parent::loadView('commerce', 'index', $commerces);
        parent::loadView('default', 'footer');
    }

    public static function actionViewCreate()
    {
        $user = self::loginVerify();

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

        parent::loadView('default', 'header', array(
            'user' => $user,
            'page' => "Novo Comércio"
        ));
        parent::loadView('commerce', 'create', $data);
        parent::loadView('default', 'footer');
    }

    public static function actionCreate($data)
    {
        $user = self::loginVerify();

        $commerce = new Commerce();
        $commerce->setData($data);
        $commerce->addComercio();

        header("location: /admin/commerce");
        exit;
    }

    public static function actionViewUpdate($id)
    {
        $user = self::loginVerify();

        $commerce = Commerce::listComercioId((int)$id);

        parent::loadView('default', 'header', array(
            'user' => $user,
            'page' => "Editar Comércio"
        ));
        parent::loadView('commerce', 'update', $commerce[0]);
        parent::loadView('default', 'footer');
    }

    public static function actionUpdate($id, $data)
    {
        $user = self::loginVerify();

        $commerce = new Commerce();
        $commerce->setData($data);
        $commerce->updateComercio((int)$id);

        header("location: /admin/commerce");
        exit;
    }

    public static function actionDelete($id)
    {
        $user = self::loginVerify();

        $commerce = new Commerce();
        $commerce->deleteComercio((int)$id);

        header("location: /admin/commerce");
        exit;
    }

    public static function actionViewReport()
    {
        $user = self::loginVerify();

        $commerces = Commerce::listComercios();

        parent::loadView("commerce", "report", $commerces);
    }

    public static function actionGetCep($cep)
    {
        $user = self::loginVerify();

        $setCep = Commerce::getCep($cep);
        echo json_encode($setCep);
    }
}